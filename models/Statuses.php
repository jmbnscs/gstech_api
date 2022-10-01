<?php
    class Statuses 
    {
        private $conn;
        private $table;

        # Properties
        public $status_id;
        public $status_name;
        public $status_table;

        # Syntax for table name
        // $this->table = $this->status_table;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create ()
        {
            // Set table name
            $this->table = $this->status_table;

            // Create Query
            $query = 'INSERT INTO ' . 
                    $this->table . '
                SET
                    status_name = :status_name';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->status_table = htmlspecialchars(strip_tags($this->status_table));
            $this->status_name = htmlspecialchars(strip_tags($this->status_name));

            // Bind Data
            $stmt->bindParam(':status_name', $this->status_name);

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

        # Get Statuses 
        public function read()
        {
            // Set table name
            $this->table = $this->status_table;

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

        # Update Statuses
        public function update() 
        {
            // Clean data
            $this->status_table = htmlspecialchars(strip_tags($this->status_table));
            $this->status_name = htmlspecialchars(strip_tags($this->status_name));
            $this->status_id = htmlspecialchars(strip_tags($this->status_id));
    
            // Set table name
            $this->table = $this->status_table;

            // Create query
            $query = 'UPDATE ' . $this->table . ' 
                    SET status_name = :status_name
                    WHERE status_id = :status_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Bind data
            $stmt->bindParam(':status_name', $this->status_name);
            $stmt->bindParam(':status_id', $this->status_id);
    
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

        # Delete Statuses
        public function delete()
        {
            // Clean data
            $this->status_table = htmlspecialchars(strip_tags($this->status_table));
            $this->status_id = htmlspecialchars(strip_tags($this->status_id));

            $this->table = $this->status_table;

            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE status_id = :status_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':status_id', $this->status_id);

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