<?php

/**
 * Class for cleanning old backup data
 */
class App
{
    protected static $clean_days;

    /**
     * Clear old error logs
     * Cut time is deffined in config file
     */
    public static function clean_log() 
    {
        self::$clean_days = constant("APP_CLEAN_DAYS");
        $src = './data';
        $target_days = self::$clean_days;
        $clean_log = "CLEAN LOG</br>";
        $counter_log = 0;

        $dir = opendir($src);
        $today = date('Y-m-d');
        $timestamp = strtotime ("-$target_days day", strtotime($today));
        $target_day = date('Y_m_d', $timestamp);
        $filter = $target_day.'_00_00_00.zip';
        $clean_log = $clean_log."Target: $filter"."</br>";

        while(false !== ( $file = readdir($dir)) ) 
        {
            $full_file = "$src/$file";
            
            if ((!is_dir($file)) && ($file < $filter) && ( $file != '.' ) && ( $file != '..' ))
            {
                $counter_log ++;
                $clean_log = $clean_log."Deleted $full_file</br>";
                unlink($full_file);
            }
        }

        $clean_log = $clean_log."Deleted $counter_log files.</br>";
        closedir($dir);
        return $clean_log;
    }
}


