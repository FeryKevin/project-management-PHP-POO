<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection
{
    // variables
    private static $dbHost = "localhost";
    private static $dbName = "poo_php";
    private static $dbUsername = "root";
    private static $dbUserpassword = "";
    private static $connection = null;
    
    // fonction connexion
    public static function connect()
    {
        if(self::$connection == null)
        {
            try
            {
              self::$connection = new PDO("mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName , self::$dbUsername, self::$dbUserpassword);
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
        }
        return self::$connection;
    }
    
    // fonction déconnexion
    public static function disconnect()
    {
        self::$connection = null;
    }

}
?>
