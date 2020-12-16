import os
import shutil
from configparser import ConfigParser
import pdfplumber
import SendMail
import DB_Connection as db

# Global variables
new_invoices_dir = None
treated_invoices_dir = None


def init():
    global new_invoices_dir
    global treated_invoices_dir
    """ Configuration 
    Reading information from config.ini in order to hide information
    as .gitignore contains "/config.ini"""
    config = ConfigParser()
    config.read('config.ini')
    new_invoices_dir = config['Directories']['new_invoices_dir']
    treated_invoices_dir = config['Directories']['treated_invoices_dir']


def main():
    invoices = check_for_new_invoices()  # returns array of invoices
    if invoices:
        for invoice in invoices:
            completed, invoice_data = extract_data(invoice)
            db.log('Extraction Completed: ' + completed.__str__())
            if completed:
                add_invoice(invoice_data)
            else:  # Due to wrong input data
                db.log('Extraction failure', 1)
                # as from address is stored in file name
                from_address = invoice.split()[-2].replace('<', '').replace('>', '')
                # Informing sender
                SendMail.send_email(from_address)  # logging in module
                db.log('Email sent due to extraction error', 1)
        update(invoices)


def check_for_new_invoices():
    """
    Generates the file names in a directory tree by walking the tree
    either top-down or bottom-up. For each directory in the tree rooted
    at directory top (including top itself), it yields a 3-tuple
    (dirpath, dirnames, filenames). Appending array if file is .pdf
    """
    invoices = []  # array of invoices
    for dirpath, subdirs, files in os.walk(new_invoices_dir):  # tuple
        for f in files:
            if f.endswith(".pdf"):
                invoices.append(
                    os.path.join(dirpath, f))  # To get a full path - names in the lists contain no path components.
    return invoices


def update(invoices):
    """cutting invoice from directory new_invoices to treated_invoices"""
    invoices.clear()
    file_names = os.listdir(new_invoices_dir)
    for file_name in file_names:
        # overwrites if exist as we have UIDs
        shutil.move(os.path.join(new_invoices_dir, file_name), os.path.join(treated_invoices_dir, file_name))


def extract_data(invoice):
    """
    :param invoice:
    :return: invoice data - array pushed into dictionary
    """
    invoice_data = {}  # creating dictionary for invoice data
    services_data = []
    invoice_approval = True

    with pdfplumber.open(invoice) as pdf:
        page = pdf.pages[0]
        text = page.extract_text()
    for row in text.split('\n'):
        if row.lower().__contains__('company name: '):
            invoice_data['Company'] = row.lower().replace('company name: ', '').upper()
        if row.lower().__contains__('date:'):
            date = row.split()[-1]
            if date.__contains__('/' or '-'):
                date = date.replace('_' or '.', '/')
            invoice_data['Date'] = date
        if row.lower().startswith('name:'):
            invoice_data['Name'] = row.lower().replace('name:', '').upper()
        if row.lower().__contains__('invoice_id'):
            invoice_data['Invoice_ID'] = row.split()[-1]
        if row.lower().startswith('total' or 'amount'):
            invoice_data['Total'] = row.split()[-1]
        if row.startswith('#'):
            service = row.split()[1].upper()
            cost = row.split()[-2]
            hours = row.split()[2]
            validated = estimation_check(service, cost)
            if validated:
                add_service(service, cost)
            else:
                add_service(service, 999999)  # adding service to estimations with cost --> inf if false
                invoice_approval = False  # boolean True from beginning. If it ever gets False the value is changed
            services_data.append({'Description': service, 'Hours': hours, 'Cost': cost, 'Approved': validated})
    invoice_data['Approved'] = invoice_approval

    for v in invoice_data.values():
        v = v.__str__()
        if v.__contains__('_') or v.__contains__(':') or v.__contains__('.'):
            extraction_completed = False
        else:
            extraction_completed = True
    # pushing array into dictionary to access data of every service (e.g. (l: 140+))
    invoice_data['Service(s)'] = services_data
    return extraction_completed, invoice_data  # returning tuple


def estimation_check(item, cost):
    """
    Comparing with estimation price in db
    If an estimation exist and diff is smaller that 20 percent
    :return: true/false boolean
    """
    validated = False
    db.mycursor.execute("SELECT * FROM estimations;")
    for row in db.mycursor:
        if item == row[0]:
            estimation = row[1]
            diff = get_change(float(cost), float(estimation))  # type cast
            if diff <= 20:
                validated = True
            else:
                validated = False
    return validated


def get_change(current, previous):
    """
    :param current price
    :param previous/estimation price
    :return: change in percentage
    """
    if current == previous:
        return 0
    try:
        return (abs(current - previous) / previous) * 100.0
    except ZeroDivisionError:
        return float('inf')


def add_service(service, cost):
    """ Adding service to estimations section in db
    :param cost:
    :param service: item """
    query = "INSERT INTO estimations (item, price) VALUES (%s, %s);"
    values = (service, int(cost))
    db.mycursor.execute(query, values)
    db.mydb.commit()
    db.log('Estimation added')


def add_invoice(invoice):
    """
    Adding invoice data to db
    :param invoice contains all information as
    an array is pushed into a dictionary
    """
    query = "INSERT INTO invoice (invoiceID, company, date, billedTo, approved) VALUES (%s, %s, %s, %s, %s);"
    values = (invoice['Invoice_ID'], invoice['Company'], invoice['Date'], invoice['Name'], invoice['Approved'])
    db.mycursor.execute(query, values)
    db.mydb.commit()
    db.log('Invoice added')

    for s in invoice['Service(s)']:
        query = "INSERT INTO service (invoiceId, name, hours, rate, approved) " \
                "VALUES ((SELECT MAX(id) FROM invoice), %s, %s, %s, %s);"
        values = (s['Description'], s['Hours'], s['Cost'], int(s['Approved']))
        db.mycursor.execute(query, values)
        db.mydb.commit()
        db.log('Service added')
