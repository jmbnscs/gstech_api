<?php
    class Restriction {
        private $conn;
        private $table = 'restriction';

        public $user_id;
        public $nav_id;
        public $restrict_access;

        public $error;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function get_user_restriction () 
        {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE user_id = :user_id';

            $stmt = $this->conn->prepare($query);
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $stmt->bindParam(':user_id', $this->user_id);

            try {
                $stmt->execute();
                return $stmt;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
            }
        }
    }