<?php
    class UserLevel 
    {
        private $conn;
        private $table = 'user_level';

        # Properties
        public $user_id;
        public $user_role;

        public $error;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create ()
        {
            $query = 'INSERT INTO ' . 
                    $this->table . '
                SET
                    user_role = :user_role';

            $stmt = $this->conn->prepare($query);

            $this->user_role = htmlspecialchars(strip_tags($this->user_role));

            $stmt->bindParam(':user_role', $this->user_role);

            try {
                $stmt->execute();
                $this->getNewUserID();
                return true;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }

        # Get UserLevel 
        public function read()
        {
            // Create Query
            $query = 'SELECT 
                *
            FROM
             ' . $this->table;
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function read_single () 
        {
            $query = 'SELECT
                * FROM ' . 
            $this->table . ' 
            WHERE
                user_id = :user_id';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':user_id', $this->user_id);

            // Execute Query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->user_id = $row['user_id'];
            $this->user_role = $row['user_role'];
        }

        # Update UserLevel
        public function update() 
        {
            $query = 'UPDATE ' . $this->table . '
                    SET user_role = :user_role
                    WHERE user_id = :user_id';
    
            $stmt = $this->conn->prepare($query);
            
            $this->user_role = htmlspecialchars(strip_tags($this->user_role));
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    
            $stmt->bindParam(':user_role', $this->user_role);
            $stmt->bindParam(':user_id', $this->user_id);
    
            try {
                $stmt->execute();
                return true;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }

        # Delete UserLevel
        public function delete() 
        {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE user_id = :user_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));

            // Bind data
            $stmt->bindParam(':user_id', $this->user_id);

            try {
                $stmt->execute();
                return true;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }

        private function getNewUserID() {
            $query = 'SELECT
                user_id FROM ' . 
            $this->table . ' 
            WHERE
                user_role = :user_role';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':user_role', $this->user_role);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->user_id = $row['user_id'];
        }
    }