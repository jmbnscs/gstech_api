<?php
    class Connection 
    {
        private $conn;
        private $table = 'connection';

        # Properties
        public $connection_id;
        public $connection_name;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Connection
        public function create ()
        {
            // Create Query
            $query = 'INSERT INTO ' . 
                    $this->table . '
                SET
                    connection_name = :connection_name';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->connection_name = htmlspecialchars(strip_tags($this->connection_name));

            // Bind Data
            $stmt->bindParam(':connection_name', $this->connection_name);

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

        # Get Connection 
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
            $query = 'SELECT * FROM ' . $this->table . ' WHERE connection_id = :connection_id';
            
            $stmt = $this->conn->prepare($query);
            $this->connection_id = htmlspecialchars(strip_tags($this->connection_id));
            $stmt->bindParam(':connection_id', $this->connection_id);

            $stmt->execute();

            return $stmt;
        }

        # Update Connection
        public function update() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET connection_name = :connection_name
                    WHERE connection_id = :connection_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->connection_name = htmlspecialchars(strip_tags($this->connection_name));
            $this->connection_id = htmlspecialchars(strip_tags($this->connection_id));
    
            // Bind data
            $stmt->bindParam(':connection_name', $this->connection_name);
            $stmt->bindParam(':connection_id', $this->connection_id);
    
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

        # Delete Connection
        public function delete() 
        {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE connection_id = :connection_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->connection_id = htmlspecialchars(strip_tags($this->connection_id));

            // Bind data
            $stmt->bindParam(':connection_id', $this->connection_id);

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