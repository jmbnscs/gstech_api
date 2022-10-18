<?php
    class Promo 
    {
        private $conn;
        private $table = 'promo';

        # Properties
        public $promo_id;
        public $plan_id;
        public $inclusion_id;

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
                    plan_id = :plan_id,
                    inclusion_id = :inclusion_id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->plan_id = htmlspecialchars(strip_tags($this->plan_id));
            $this->inclusion_id = htmlspecialchars(strip_tags($this->inclusion_id));

            // Bind Data
            $stmt->bindParam(':plan_id', $this->plan_id);
            $stmt->bindParam(':inclusion_id', $this->inclusion_id);

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
                    SET plan_id = :plan_id, 
                        inclusion_id = :inclusion_id
                    WHERE promo_id = :promo_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->plan_id = htmlspecialchars(strip_tags($this->plan_id));
            $this->inclusion_id = htmlspecialchars(strip_tags($this->inclusion_id));
            $this->promo_id = htmlspecialchars(strip_tags($this->promo_id));
    
            // Bind data
            $stmt->bindParam(':plan_id', $this->plan_id);
            $stmt->bindParam(':inclusion_id', $this->inclusion_id);
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