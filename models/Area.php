<?php
    class Area 
    {
        private $conn;
        private $table = 'area';

        # Properties
        public $area_id;
        public $area_name;

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
                    area_name = :area_name';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->area_name = htmlspecialchars(strip_tags($this->area_name));

            // Bind Data
            $stmt->bindParam(':area_name', $this->area_name);

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

        # Get Area 
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
            $query = 'SELECT * FROM ' . $this->table . ' WHERE area_id = :area_id';
            
            $stmt = $this->conn->prepare($query);
            $this->area_id = htmlspecialchars(strip_tags($this->area_id));
            $stmt->bindParam(':area_id', $this->area_id);

            $stmt->execute();

            return $stmt;
        }

        # Update Area
        public function update() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET area_name = :area_name
                    WHERE area_id = :area_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->area_name = htmlspecialchars(strip_tags($this->area_name));
            $this->area_id = htmlspecialchars(strip_tags($this->area_id));
    
            // Bind data
            $stmt->bindParam(':area_name', $this->area_name);
            $stmt->bindParam(':area_id', $this->area_id);
    
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

        # Delete Area
        public function delete() 
        {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE area_id = :area_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->area_id = htmlspecialchars(strip_tags($this->area_id));

            // Bind data
            $stmt->bindParam(':area_id', $this->area_id);

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