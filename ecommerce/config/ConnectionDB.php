<?php
    class ConnectionDB{
        public static function connect(){
            $hostname = "localhost";
            $username = "root";
            $password = "";
            $database = "id22394051_ecommerce_php_sweets";    
            $db = new mysqli($hostname, $username, $password, $database);
            $db->query("SET NAMES 'utf8'");
            return $db;
        }
    }
?>