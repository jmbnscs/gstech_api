<?php
    class Inclusion 
    {
        private $conn;
        private $table = 'inclusion';

        # Properties
        public $inclusion_id;
        public $inclusion_code;
        public $inclusion_name;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Inclusion
        public function create ()
        {
            // Create Query
            $query = 'INSERT INTO ' . 
                    $this->table . '
                SET
                    inclusion_code = inclusion_gen_code(:inclusion_name),
                    inclusion_name = :inclusion_name';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->inclusion_name = htmlspecialchars(strip_tags($this->inclusion_name));

            // Bind Data
            $stmt->bindParam(':inclusion_name', $this->inclusion_name);

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

        # Get Inclusion 
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

        # Update Inclusion
        public function update() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET inclusion_code = inclusion_gen_code(:inclusion_name),
                        inclusion_name = :inclusion_name
                    WHERE inclusion_id = :inclusion_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->inclusion_name = htmlspecialchars(strip_tags($this->inclusion_name));
            $this->inclusion_id = htmlspecialchars(strip_tags($this->inclusion_id));
    
            // Bind data
            $stmt->bindParam(':inclusion_name', $this->inclusion_name);
            $stmt->bindParam(':inclusion_id', $this->inclusion_id);
    
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

        # Delete Inclusion
        public function delete() 
        {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE inclusion_id = :inclusion_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->inclusion_id = htmlspecialchars(strip_tags($this->inclusion_id));

            // Bind data
            $stmt->bindParam(':inclusion_id', $this->inclusion_id);

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