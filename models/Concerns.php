<?php
    class Concerns 
    {
        private $conn;
        private $table = 'concerns';

        # Properties
        public $concern_id;
        public $concern_category;
        public $technical_support_access;
        public $customer_access;

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
                    concern_category = :concern_category,
                    customer_access = :customer_access';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->concern_category = htmlspecialchars(strip_tags($this->concern_category));
            $this->customer_access = htmlspecialchars(strip_tags($this->customer_access));

            // Bind Data
            $stmt->bindParam(':concern_category', $this->concern_category);
            $stmt->bindParam(':customer_access', $this->customer_access);

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

        # Get Concerns 
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

        public function read_single()
        {
            $query = 'SELECT * FROM ' . $this->table . ' 
            WHERE concern_id = :concern_id';
            
            $stmt = $this->conn->prepare($query);
            $this->concern_id = htmlspecialchars(strip_tags($this->concern_id));
            $stmt->bindParam(':concern_id', $this->concern_id);

            $stmt->execute();

            return $stmt;
        }

        # Update Concerns
        public function update() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET concern_category = :concern_category, 
                        customer_access = :customer_access
                    WHERE concern_id = :concern_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->concern_category = htmlspecialchars(strip_tags($this->concern_category));
            $this->customer_access = htmlspecialchars(strip_tags($this->customer_access));
            $this->concern_id = htmlspecialchars(strip_tags($this->concern_id));
    
            // Bind data
            $stmt->bindParam(':concern_category', $this->concern_category);
            $stmt->bindParam(':customer_access', $this->customer_access);
            $stmt->bindParam(':concern_id', $this->concern_id);
    
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

        # Delete Concerns
        public function delete() 
        {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE concern_id = :concern_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->concern_id = htmlspecialchars(strip_tags($this->concern_id));

            // Bind data
            $stmt->bindParam(':concern_id', $this->concern_id);

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