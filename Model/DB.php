<?php
Class DB{
    private static $host;
    private static $us;
    private static $pw;
    private static $db;
    private static $pt;

/**
 * DB connection
 */
    static function connection()
    {
        self::$host = constant('DB_HOST');
        self::$us = constant('DB_USER');
        self::$pw = constant('DB_PASS');
        self::$db = constant('DB');
        self::$pt = constant('DB_PORT');

        if ($connection = new mysqli(self::$host, self::$us, self::$pw, self::$db, self::$pt))
        {
            mysqli_set_charset($connection, "utf8mb4");
            return $connection;
        } 

        else 
        {
            printf("Falló la conexión: %s\n", mysqli_connect_error());
            exit();
        }
    }

    /**************************************************************************************/
    /************************** data consultation *****************************************/
    /**************************************************************************************/

    /**
     * Returns an array with the database tables
     */

    static function get_tables() 
    {
        $mysqli = self::connection();
        $consulta = "show tables";
        $result = mysqli_query($mysqli, $consulta);

        if ($result) 
        {
            $resultado = [];
            while ($r_array = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                array_push($resultado,$r_array);
            }
            return $resultado;
        } 

        else 
        {
            return false;
        }
        
        /* free result set */
        $result->close();
        /* close connection */
        $mysqli->close();
    }

    /**
    * Returns an array with all the data in the table
    * false if the query fails
    */
    static function backup_table($table) 
    {  
        $mysqli = self::connection();
        $consulta = "SELECT * FROM $table";
        $result = mysqli_query($mysqli, $consulta);
        if ($result) 
        {
            $resultado = [];
            while ($r_array = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                array_push($resultado,$r_array);
            }
            return $resultado;
        }
        
        else 
        {
            return false;
        }
        
        /* free result set */
        $result->close();
        /* close connection */
        $mysqli->close();
    }
}
?>
