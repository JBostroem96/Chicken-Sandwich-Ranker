<?php

    //This class' purpose is to connect to the database
    class DB {

        //This function's purpose is to connect to the database
        public function connect() {

            require_once(dirname(dirname(__FILE__)) . '\..\config\dbconnection.php');
                
            $db = new PDO("mysql:host=" . DB_HOST  . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            return $db;
        }
    }
    
?>
	
