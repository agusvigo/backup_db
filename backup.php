<?php

require './.config/.config.php';
require './Model/DB.php';
require './Controller/Controller.php';
require './App/App.php';

//tables backup
$tables = DB::get_tables();
$rows = 0;
$table_rows = 0;
$Now = new DateTime('now');
$timestamp = $Now->format('Y_m_d_H_i_s');
$filename = "./data/Backup_$timestamp.sql";
$act_table ='';
$password = '12345';
$log = '';
$log_mail = '';

foreach ($tables as $table) 
{
    $string_1 = "";

    foreach ($table as $key=>$value) 
    {
        $table_data = DB::backup_table($value);
        $act_table = $value;
        $table_rows = count($table_data);
    }

    if ($table_rows > 0) 
    {
        foreach ($table_data as $data) 
        {
            $string_1 ="INSERT IGNORE INTO $act_table";
            $string_2 = "";
            $string_3 = "";
            $rows = count($data);
            $count = 1;
            foreach ($data as $key_2=>$value_2) 
            {
                if ($count === 1) 
                {
                    $string_2 = $key_2;
                    $string_3 = '"'.$value_2.'"';
                }

                if (($count <= $rows) && ($count !== 1)) 
                {
                    $string_2 = "$string_2, $key_2";
                    $string_3 = $string_3.','.'"'.$value_2.'"';
                }
                $count ++;
            }
    
            
            $content = "$string_1 ($string_2) VALUES ($string_3);\n";
    
            
            $filename = "./data/$act_table-$timestamp.sql";
            $filename_z = "$act_table-$timestamp.sql";
    
            // that's where $somecontent will go when we fwrite() it.
            if (!$fp1 = fopen($filename, 'a')) 
            {
                $log = $log."Warning: Cannot open file ($filename)\n";
                $log_mail = $log_mail."<p>Warning: Cannot open file ($filename)</p>";
            }
        
            // Write $somecontent to our opened file.
            if (fwrite($fp1, $content) === FALSE) 
            {
                $log = $log."Warning: Cannot write to file ($filename)\n";
                $log_mail = $log_mail."<p>Warning: Cannot write to file ($filename)</p>";
            }

            fclose($fp1);
            
        }
        //We add the created file to a zip
        $log = $log."Success: $table_rows rows saved from table $act_table\n";
        $log_mail = $log_mail."<p>Success: $table_rows rows saved from table $act_table</p>";
        $zip = new ZipArchive();
        $filename_zip = "./data/$timestamp.zip";
    
        if ($zip->open($filename_zip, ZipArchive::CREATE)!==TRUE) 
        {
            exit("cannot open <$filename_zip>\n");
        }
    
        $zip->addFile($filename, $filename_z);
        // Set global (for each file) password
        $zip->setPassword($password);    
    
        // This part will set that file will be encrypted with your password
        //$zip->setEncryptionName($filename_z, ZipArchive::EM_AES_128);   // Have to encrypt each file in zip (Needs PHP >= 7.2.0)
        $zip->close();
    
        //Delete the file
        unlink($filename);

    }
}

//Clean old logs
$clean_old_logs =  APP::clean_log();

//We add the OK to the log
$log = $log.$clean_old_logs.'Backup Sucessfull';
$log_mail = $log_mail.$clean_old_logs.'<p>Backup Sucessfull</p>';

//Save the log in a file
$filename_log = "./data/log.txt";
$filename_log_z = "log.txt";
$fp2 = fopen($filename_log, 'a');
fwrite($fp2, $log);
fclose($fp2);

//Add the file log to the zipp
$zip = new ZipArchive();
$filename_zip = "./data/$timestamp.zip";

if ($zip->open($filename_zip, ZipArchive::CREATE)!==TRUE) 
{
    exit("cannot open <$filename_zip>\n");
}

$zip->addFile($filename_log, $filename_log_z);
// Set global (for each file) password
$zip->setPassword($password);    

// This part will set that file will be encrypted with your password
//$zip->setEncryptionName($filename_log_z, ZipArchive::EM_AES_128);   // Have to encrypt each file in zip (Needs PHP >= 7.2.0)
$zip->close();

//Delete the file
unlink($filename_log);

//We send an email to the admin with the result of the Backup
Controller::mail_to_admin('Backup BBDD', $log_mail);

echo 'Backup Sucessfull'
?>