import email
import imaplib
import os
import uuid
from configparser import ConfigParser
import SendMail
import DB_Connection as db

# Global variables
mail = None
attachment_dir = None


def init():
    global attachment_dir
    global mail
    """Configuration"""
    config = ConfigParser()
    config.read('config.ini')
    attachment_dir = config['Directories']['new_invoices_dir']
    user = config['Gmail']['user']
    password = config['Gmail']['password']
    host = config['Gmail']['host']
    port = config['Gmail']['port']
    while not mail:
        mail = connection(user, password, host, port)  # calling function for establishing connection
    db.log('Mail connection established')


def connection(address, password, host, port):
    """
    Connects to Outlook
    :returns: mail connection
    """
    db.log('Connecting to ' + host + "...")
    mail = imaplib.IMAP4_SSL(host, port)  # port for connecting
    mail.login(address, password)
    return mail


def read_inbox():
    mail.select('Inbox')
    # Returned data is a tuple
    # - we're only interested in data, so a placeholder is placed
    _, data = mail.search(None, '(UNSEEN)')  # search for unread emails
    inbox_item_list = data[0].split()  # list of references to emails
    if not inbox_item_list:
        print('No unread emails')  # not logging due to memory
    else:
        for item in inbox_item_list:
            # Returned data are tuples of message part envelope and data
            # The latter type of payload is indicated as multipart/* or message/rfc822
            _, email_data = mail.fetch(item, '(RFC822)')  # returns email in byte form
            # extracting the body, which is raw text of the whole
            # email including headers and alternate payloads
            string_email = email_data[0][1].decode("utf-8")
            email_message = email.message_from_string(string_email)  # converting to object
            if get_invoices(email_message):
                db.log('Found email - Invoice Collected')
            else:
                sender_email = email_message['From']
                SendMail.send_email(sender_email)  # sends default mail
                db.log('Found email with no valid attachment', 1)
            mail.uid('STORE', item, '+FLAGS', '\\SEEN')  # marking email as read


def get_invoices(msg):
    invoice_collected = False
    sender_email = msg['From']
    for part in msg.walk():  # iterates through email object
        if part.get_content_maintype() == 'multipart':  # multipart/alternative = html/text
            continue  # skipping to next iteration of msg.walk()
        if part.get_content_disposition() is None:  # header
            continue
        file_name = part.get_filename()
        if not file_name.endswith('.pdf'):
            continue
        if bool(file_name):
            file_path = os.path.join(attachment_dir, sender_email + ' ' + uuid.uuid4().__str__() + '_' + file_name)
            with open(file_path, 'wb') as f:  # wb = write binary
                f.write(part.get_payload(decode=True))
            invoice_collected = True
    return invoice_collected
