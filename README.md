# backup_db
<h1>MySQL data backup with PHP</h1>
<p>PHP script to backup all the data in the tables of your MySQL database. When executing it, it creates a ZIP file and inside it creates a file with the data of each one of the tables of the database, so that simply decompressing the file and we have the command to restore all the data of each one of the tables from the database independently. Once completed, send an email to the chosen email address using PHP mailer and delete the old copies with the cut-off date entered in the ".config" file.</p>
<p>For it to work correctly you only need to copy it to your server, enter the correct data in the ".config" file and the data of your email account in "Controller.php" in case you want to use PHP mailer. Once you've don this just create a cron job to run the script when you want.</p>
<p>Files will be saved in "data" directory</p>
<p>Any questions you can contact me through github or at agustin.ferreiroa@afgdev.es.</p>
