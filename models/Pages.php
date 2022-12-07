<?php
    class Pages {
        private $conn;
        private $table;

        // Pages
        public $page_name;
        public $navbar_id;

        // Buttons
        public $btn_id;
        public $identifier;
        
        public $page_dir;
        public $description;

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

        public function read_pages () {
            $query = 'SELECT * FROM pages';

            $stmt = $this->conn->prepare($query);

            try {
                $stmt->execute();
                return $stmt;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
            }
        }

        public function read_buttons () {
            $query = 'SELECT * FROM pages_button';

            $stmt = $this->conn->prepare($query);

            try {
                $stmt->execute();
                return $stmt;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
            }
        }

        public function get_description () {
            $query = 'SELECT description FROM pages WHERE navbar_id = :navbar_id';

            $stmt = $this->conn->prepare($query);

            $this->navbar_id = htmlspecialchars(strip_tags($this->navbar_id));
            $stmt->bindParam(':navbar_id', $this->navbar_id);

            try {
                $stmt->execute();
                return $stmt;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
            }
        }
    }