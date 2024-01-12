<?php

class DatabaseConnection
{

    private $conn = null;

    function connectDB(){
        try {

            $this->conn = new PDO("mysql:host=oppenheim.iad1-mysql-e2-17a.dreamhost.com;dbname=burgerdex", "apanemia", "milkmilk1");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch (PDOException $e){

            $this->conn = null;

            die ("Major Error" . $e->getMessage());
        }

       return $this->conn;

    }

}
?>
