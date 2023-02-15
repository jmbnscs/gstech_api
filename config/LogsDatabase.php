<?php
    class LogsDatabase
    {
        // DB Params
        private $host = 'localhost';
        private $db_name = 'u575223139_logs';
        private $username = 'u575223139_finalslogs';
        private $password = 'i@Bh4x/fY8*D';
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