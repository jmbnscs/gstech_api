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

        # Update Area
        public function update()
        {

        }

        # Delete Area
        public function delete()
        {
            
        }
    }