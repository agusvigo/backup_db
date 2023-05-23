# backup_db
<h1>MySQL data backup with PHP</h1>
PHP script to backup all the data in the tables of your MySQL database. When executing it, it creates a ZIP file and inside it creates a file with the data of each one of the tables of the database, so that simply decompressing the file and we have the command to resaturate all the data of each one of the tables from the database independently. Once completed, send an email to the chosen email address using PHP mailer and delete the old copies with the cut-off date entered in the ".config" file.
For it to work correctly you only need to copy it to your server, enter the correct data in the ".config" file and the data of your email account in "Controller.php" in case you want to use PHP mailer.
Any questions you can contact me through github or at agustin.ferreiroa@afgdev.es.
