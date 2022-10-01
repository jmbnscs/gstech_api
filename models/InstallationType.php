<?php
    class InstallationType 
    {
        private $conn;
        private $table = 'installation_type';

        # Properties
        public $install_type_id;
        public $install_type_name;

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
                    install_type_name = :install_type_name';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->install_type_name = htmlspecialchars(strip_tags($this->install_type_name));
            // $this->compute_rpm();

            // Bind Data
            $stmt->bindParam(':install_type_name', $this->install_type_name);

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

        # Get InstallationType 
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

        # Update InstallationType
        public function update() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET install_type_name = :install_type_name
                    WHERE install_type_id = :install_type_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->install_type_name = htmlspecialchars(strip_tags($this->install_type_name));
            $this->install_type_id = htmlspecialchars(strip_tags($this->install_type_id));
    
            // Bind data
            $stmt->bindParam(':install_type_name', $this->install_type_name);
            $stmt->bindParam(':install_type_id', $this->install_type_id);
    
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

        # Delete InstallationType
        public function delete() 
        {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE install_type_id = :install_type_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->install_type_id = htmlspecialchars(strip_tags($this->install_type_id));

            // Bind data
            $stmt->bindParam(':install_type_id', $this->install_type_id);

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