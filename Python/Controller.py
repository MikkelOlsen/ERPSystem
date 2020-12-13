import imaplib
import time
import mysql.connector
import InvoiceExtraction
import RetrieveEmails

running_error_handling = False


def search_mailbox():
    RetrieveEmails.read_inbox()


def treat_invoice():
    InvoiceExtraction.main()


def run():
    search_mailbox()
    treat_invoice()


def init():
    RetrieveEmails.init()
    InvoiceExtraction.init()


def error_handling(error):
    global running_error_handling
    running_error_handling = True
    print(error)
    print('Waiting for reestablishing ..')
    time.sleep(15)
    main()


def main():
    global running_error_handling
    running_error_handling = False
    try:
        init()
        while not running_error_handling:
            run()
            time.sleep(40)
    except imaplib.IMAP4_SSL.error as e:
        error_handling(e)
    except mysql.connector.errors.InterfaceError as e:
        error_handling(e)
    except ConnectionRefusedError as e:
        error_handling(e)


if __name__ == '__main__':
    main()
