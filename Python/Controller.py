import imaplib
import time
import mysql.connector
import InvoiceExtraction
import RetrieveEmails
import DB_Connection as db

running_error_handling = False


def search_mailbox():
    RetrieveEmails.read_inbox()


def treat_invoice():
    InvoiceExtraction.main()


def run():
    search_mailbox()
    treat_invoice()


def init():
    db.connect_db()
    RetrieveEmails.init()
    InvoiceExtraction.init()


def error_handling(error):
    global running_error_handling
    running_error_handling = True
    db.log(error, 1)
    print('Waiting for reestablishing ..')
    time.sleep(120)
    main()


def main():
    global running_error_handling
    running_error_handling = False
    try:
        init()
        while not running_error_handling:
            run()
            time.sleep(60)
    except (imaplib.IMAP4_SSL.error, mysql.connector.errors.InterfaceError, ConnectionRefusedError) as e:
        error_handling(e)


if __name__ == '__main__':
    main()
