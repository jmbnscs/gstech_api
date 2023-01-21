<?php
    class Database 
    {
        // DB Params
        private $host = 'localhost';
        private $db_name = 'u575223139_pilot_bmsdb';
        private $username = 'u575223139_pilot';
        private $password = 'huydI:9J[';
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