<?php
    class LogsDatabase
    {
        // DB Params
        private $host = 'localhost';
        private $db_name = 'id20026740_gstech_logs';
        private $username = 'id20026740_logs';
        private $password = '9f]\zm-QoWT=SO6}';
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