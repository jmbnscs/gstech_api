<?php
    class Database 
    {
        // DB Params
        private $host = 'localhost';
        private $db_name = 'id20026740_gstech_bms_db';
        private $username = 'id20026740_bms';
        private $password = 'cSuXE8v#r*aW7Wb-';
        private $conn;

        // DB Connect
        public function connect()
        {
            $this->conn = null;

            try
            {
                $this->conn = new PDO('mysql:host=' .$this->host. ';dbname=' .$this->db_name, $this->username, $this->password);

                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e)
            {
                echo 'Connection Error: '.$e->getMessage();
            }

            return $this->conn;
        }
    }