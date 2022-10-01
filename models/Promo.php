<?php
    class Promo 
    {
        private $conn;
        private $table = 'promo';

        # Properties
        public $promo_id;
        public $netflix;
        public $fiber_switch;

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
                    netflix = :netflix,
                    fiber_switch = :fiber_switch';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->netflix = htmlspecialchars(strip_tags($this->netflix));
            $this->fiber_switch = htmlspecialchars(strip_tags($this->fiber_switch));

            // Bind Data
            $stmt->bindParam(':netflix', $this->netflix);
            $stmt->bindParam(':fiber_switch', $this->fiber_switch);

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

        # Get Promo 
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

        # Update Promo
        public function update() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET netflix = :netflix, 
                        fiber_switch = :fiber_switch
                    WHERE promo_id = :promo_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->netflix = htmlspecialchars(strip_tags($this->netflix));
            $this->fiber_switch = htmlspecialchars(strip_tags($this->fiber_switch));
            $this->promo_id = htmlspecialchars(strip_tags($this->promo_id));
    
            // Bind data
            $stmt->bindParam(':netflix', $this->netflix);
            $stmt->bindParam(':fiber_switch', $this->fiber_switch);
            $stmt->bindParam(':promo_id', $this->promo_id);
    
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

        # Delete Promo
        # Note: Cannot be used because of foreign key in the table
        public function delete() 
        {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE promo_id = :promo_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->promo_id = htmlspecialchars(strip_tags($this->promo_id));

            // Bind data
            $stmt->bindParam(':promo_id', $this->promo_id);

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