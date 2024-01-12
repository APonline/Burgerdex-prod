<?php

class DatabaseConnection
{

    private $conn = null;

    function connectDB(){
        try {
            
            $this->conn = new PDO("mysql:host=".$_ENV['HOST'].";dbname=".$_ENV['DB']."", $_ENV['USER'], $_ENV['PASS']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch (PDOException $e){

            $this->conn = null;

            die ("Major Error" . $e->getMessage());
        }

       return $this->conn;

    }

}
?>
