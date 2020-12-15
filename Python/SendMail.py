import smtplib
from configparser import ConfigParser
from email.mime.image import MIMEImage
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
import DB_Connection as db


def send_email(to_address):
    message = 'Sorry for the inconvenience but we are experiencing ' \
              '<br>some issues extracting your invoice due to our new ' \
              '<br>system. Please use the attached template to format' \
              '<br>your invoice in order to receive your payment sooner.'
    """Configuration"""
    config = ConfigParser()
    config.read('config.ini')
    user = config['Gmail']['user']
    password = config['Gmail']['password']
    host = config['Gmail']['SMTP_server']
    port = config['Gmail']['SMTP_port']
    logo = config['Logo']['logo']
    invoice_template = config['Template']['template']

    """
    The approach is to create a message root structure and attaching parts within.
    """
    msg = MIMEMultipart('related')
    msg['Subject'] = "Sorry for the inconvenience..."
    msg['From'] = user
    msg['To'] = to_address

    # Creating the body of the message
    msgAlternative = MIMEMultipart('alternative')
    msg.attach(msgAlternative)
    text = MIMEText('<html><head></head><body>'
                    '<h2>Hi!</h2><br>'
                    '<p>%s' % message + '<br><br>'
                    + 'Kind regards<br>Main Office - VirksomhedX'
                      '</p></body></html>', 'html', 'utf-8')
    # _maintype as the Content-Type major type (e.g. text or image)
    # and _params is a parameter key/value dictionary
    msgAlternative.attach(text)
    with open(logo, 'rb') as l:  # closes automatically
        msgImage = MIMEImage(l.read())

    with open(invoice_template, 'rb') as it:  # closes automatically
        msgAttachment = MIMEMultipart(it.read())

    # Define the image's ID as referenced above
    msgImage.add_header('Content-ID', '<image1>')
    msg.attach(msgImage)

    # adding attachment
    msgAttachment.add_header('Content-Disposition', 'attachment', filename='invoice_template.xlsx')
    msg.attach(msgAttachment)

    try:
        with smtplib.SMTP_SSL(host, port) as server:
            server.ehlo()
            server.login(user, password)
            server.sendmail(user, to_address, msg.as_string())
            server.close()
            db.log('Email sent')
    except:
        db.log('Something went wrong while sending')
