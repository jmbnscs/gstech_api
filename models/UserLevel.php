<?php
    class UserLevel 
    {
        private $conn;
        private $table = 'user_level';

        # Properties
        public $user_id;
        public $user_role;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create ()
        {
            // Create Query
            $query = 'INSERT INTO ' . 
                    $this->table . '
                SET
                    user_role = :user_role';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->user_role = htmlspecialchars(strip_tags($this->user_role));

            // Bind Data
            $stmt->bindParam(':user_role', $this->user_role);

            // Execute Query
            if ($stmt->execute())
            {
                return true;
            }
            else
            {
                // Print error if something goes wrong
                printf("Error: %s.\n", $stmt->error);

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

        # Update UserLevel
        public function update() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET user_role = :user_role
                    WHERE user_id = :user_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->user_role = htmlspecialchars(strip_tags($this->user_role));
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    
            // Bind data
            $stmt->bindParam(':user_role', $this->user_role);
            $stmt->bindParam(':user_id', $this->user_id);
    
            // Execute query
            if($stmt->execute()) {
                return true;
            }
            else {
                // Print error
                printf("Error: %s.\n", $stmt->error);
    
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

            // Execute query
            if($stmt->execute()) {
                return true;
            }
            else {
                // Print error
                printf("Error: %s.\n", $stmt->error);

                return false;
            }
        }
    }