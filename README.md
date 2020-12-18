[2:35 AM] Mark Aastrup Cederborg
# README
Our solution is already being hosted on a Linux server by Digital Ocean, which means that it’s currently accessible by following a URL - 174.138.13.127/. This URL gives the viewer access to the entire Web-Platform part of the project, with the Python script running in the background. In order to utilize the entire program, a mail is needed to be sent to hovedkontorvirksomhedx@gmail.com.

<details><summary>How does the program work?</summary>
<p>

As the Web-Platform retrieves data from the database, there won't appear much at the dashboard page other than some test invoices sent by us in order to illustrate the concept. Whenever a service has unapproved as its status, the field of approving an invoice is locked. However, the “unapproved service” field can be clicked (on the warning icon or text) in order to change some values of services relating to the given invoice. If the “Save services” is clicked the services get approved and the “Approve invoice” button is unlocked. The following illustrates the process of approving an invoice on the Web-Platform.

Step 1. 
 ![image][gitimages/step1.jpg]
Step 2.
 ![image][gitimages/step2.jpg]
Step 3.
 ![image][gitimages/step3.jpg]

The Web-Platform implements a logging system as well. This is mostly done for our sake as prints don't appear on the server. Instead, we chose to log some of the main tasks in our database in order to validate the program running as expected. The Web-Platform retrieves information about the log table appearing in the “Log” section
</p>
</details>



<details><summary>How to host the solution locally?</summary>
<p>
As the solution consists of several parts including different languages, the setup for running it locally is rather complicated. The simplest way to start this process is by downloading the ERP-System repository from GitHub and then placing the entire folder into your local Apache servers html / web folder and importing the database .sql file into your local MySQL server.

<b>If you already have your own server, skip this part</b>
<details><summary>Setting up PHP and MySQL</summary>
<p>

In case you don’t have a local Apache and MySQL server to execute the PHP part of the program, then the easiest way to fulfill these requirements is to download a program called XAMPP, this is a program which will install a local Apache and MySQL server. When this is installed, start up the XAMPP control panel and start the services “Apache” and “MySQL” as seen below.

 ![image][gitimages/xampp.jpg]

Once this is done, navigate to your localhost and to phpmyadmin (This is usually localhost/phpmyadmin), In here, create a new database by clicking on the “New” button on the left menu, give the database a name. When it’s done, select the database, navigate to “Import” and choose the sql file located in the root folder of the downloaded repository.
 ![image][gitimages/phpmyadmin.jpg]

 Now that this is done, copy the rest of the code into your xampp/htdocs/{a folder you made}, now you have your own local Apache and MySQL server.
</p>
</details>
<b>Continue from here if you already have Apache and MySQL server’s setup</b>
Now that you’ve set up your local servers, placed the files correctly and imported the database, all there’s left to do is create both the Python script and PHP codes config files and run the Python script. For the PHP config, go into the config folder located in the root directory and create a file called “Database.config.php”, then write the following code:
<b>If you installed XAMPP you can use the root user, otherwise replace the user and password with the database user you have.</b>

```php
<?php
    CONST       _DB_HOST_      = 'localhost',
                _DB_NAME_      = 'THE NAME OF YOUR DATABASE',
                _DB_USER_      = 'root',
                _DB_PASSWORD_  = '',
                _DB_PREFIX_    = '',
                _MYSQL_ENGINE_ = 'InnoDB';

```

</p>
<details>
<summary>Setting up Python</summary>
<p>
The Python program is found within the Python folder, which can run separately by executing the Controller.py. The Python program doesn’t depend on the Web-Platform in any way, but on the database. However, the Python code can be executed without having to connect with the database due to several try-catches implemented (cf. Error Handling) but won't function as expected due to being unable to select and insert data. A requirements.txt file is created (cf. requirements.txt) along with a venv folder to set up the virtual environment. Most of the libraries are already a part of Python version 3.8, which is the one used for coding the program. You will find a config.ini file both for setting up the program for the server and local. The local setup is currently out commented.in the appendices, which should be placed within the Python directory. Otherwise, the config.ini file is as follows:

```
FOR LOCAL
[Gmail]
user = hovedkontorvirksomhedx@gmail.com
password = pazpeq-wuDbi8-gobsyn
host = imap.gmail.com
port = 993
SMTP_server = smtp.gmail.com
SMTP_port = 465

[Logo]
logo = /Users/markcederborg/Documents/GitHub/ERPSystem/Python/logo.png

[Template]
template = /Users/markcederborg/Documents/GitHub/ERPSystem/Python/Attachment_Dir/Invoice_template.xlsx

[Database]
host=localhost
user=root
password=!Sommer2017
database=erp

[Directories]
new_invoices_dir = /Users/markcederborg/Documents/GitHub/ERPSystem/Python/Attachment_Dir/new_invoices
treated_invoices_dir = /Users/markcederborg/Documents/GitHub/ERPSystem/Python/Attachment_Dir/treated_invoices
```
<i>Please note that the paths should be replaced according to the directory, where you have placed the folder on your local machine.</i>
</p>
</details>
</details>
