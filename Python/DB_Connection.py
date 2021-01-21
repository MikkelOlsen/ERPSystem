import mysql.connector
from configparser import ConfigParser

mydb, mycursor = None, None


def connect_db():
    global mydb
    global mycursor

    config = ConfigParser()
    config.read('config.ini')
    print('Connecting database...')
    mydb = mysql.connector.connect(
        host=config['Database']['host'],
        user=config['Database']['user'],
        password=config['Database']['password'],
        database=config['Database']['database'],
        auth_plugin='mysql_native_password'
    )
    if mydb:
        mycursor = mydb.cursor(buffered=True)  # for executing commands # creating "cached zone" not to get overwritten
        log('Database Connection Established.')


def log(message, error='0'):  # 1 or 0 as default
    query = ("INSERT INTO log (message, error) VALUES (%s, %s);")
    values = (message, error)
    mycursor.execute(query, values)
    mydb.commit()
