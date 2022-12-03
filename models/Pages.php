<?php
    class Pages {
        private $conn;
        private $table;

        public $user_id;
        public $nav_id;
        public $page_button;

        public $error;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function get_btn_restriction () 
        {
            $query = 'SELECT * FROM restrict_buttons WHERE user_id = :user_id AND nav_id = :nav_id';

            $stmt = $this->conn->prepare($query);
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $this->nav_id = htmlspecialchars(strip_tags($this->nav_id));
            $stmt->bindParam(':user_id', $this->user_id);
            $stmt->bindParam(':nav_id', $this->nav_id);

            try {
                $stmt->execute();
                return $stmt;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
            }
        }
    }