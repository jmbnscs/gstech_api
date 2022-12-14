<?php
    class Plan 
    {
        private $conn;
        private $table = 'plan';

        public $plan_id;
        public $plan_name;
        public $bandwidth;
        public $price;
        public $rate_per_minute;
        public $plan_status_id;

        public $error;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function create ()
        {
            $this->plan_name = htmlspecialchars(strip_tags($this->plan_name));
            $this->bandwidth = htmlspecialchars(strip_tags($this->bandwidth));
            $this->price = htmlspecialchars(strip_tags($this->price));

            $query = 'INSERT INTO ' . 
                    $this->table . '
                SET
                    plan_name = :plan_name,
                    bandwidth = :bandwidth,
                    price = :price,
                    rate_per_minute = plan_compute_rpm(:price)';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':plan_name', $this->plan_name);
            $stmt->bindParam(':bandwidth', $this->bandwidth);
            $stmt->bindParam(':price', $this->price);

            try {
                $stmt->execute();
                $this->getID();
                return true;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }

        # Get Plans
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

        public function read_active()
        {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE plan_status_id = 1';
            
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function read_single () 
        {
            $query = 'SELECT
                * FROM ' . 
            $this->table . ' 
            WHERE
                plan_id = :plan_id';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':plan_id', $this->plan_id);

            // Execute Query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->plan_id = $row['plan_id'];
            $this->plan_name = $row['plan_name'];
            $this->bandwidth = $row['bandwidth'];
            $this->price = $row['price'];
            $this->plan_status_id = $row['plan_status_id'];
        }

        # Update Plan
        public function update() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET plan_name = :plan_name, 
                        bandwidth = :bandwidth, 
                        price = :price, 
                        rate_per_minute = plan_compute_rpm(:price),
                        plan_status_id = :plan_status_id
                    WHERE plan_id = :plan_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->plan_name = htmlspecialchars(strip_tags($this->plan_name));
            $this->bandwidth = htmlspecialchars(strip_tags($this->bandwidth));
            $this->price = htmlspecialchars(strip_tags($this->price));
            $this->plan_status_id = htmlspecialchars(strip_tags($this->plan_status_id));
            $this->plan_id = htmlspecialchars(strip_tags($this->plan_id));
    
            // Bind data
            $stmt->bindParam(':plan_name', $this->plan_name);
            $stmt->bindParam(':bandwidth', $this->bandwidth);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':plan_status_id', $this->plan_status_id);
            $stmt->bindParam(':plan_id', $this->plan_id);
    
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

        public function update_status() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET 
                        plan_status_id = :plan_status_id
                    WHERE plan_id = :plan_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->plan_id = htmlspecialchars(strip_tags($this->plan_id));
            $this->plan_status_id = htmlspecialchars(strip_tags($this->plan_status_id));
            
            // Bind data
            $stmt->bindParam(':plan_id', $this->plan_id);
            $stmt->bindParam(':plan_status_id', $this->plan_status_id);
    
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

        # Delete Plan
        public function delete() 
        {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE plan_id = :plan_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->plan_id = htmlspecialchars(strip_tags($this->plan_id));

            // Bind data
            $stmt->bindParam(':plan_id', $this->plan_id);

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

        // Get ID of newly created plan
        private function getID()
        {
            // Create query
            $query = 'SELECT plan_get_created_id() AS plan_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->plan_id = $row['plan_id'];
        }

        public function isPlanNameExist()
        {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE plan_name = :plan_name';

            $stmt = $this->conn->prepare($query);

            $this->plan_name = htmlspecialchars(strip_tags($this->plan_name));
            $stmt->bindParam(':plan_name', $this->plan_name);

            try {
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row) {
                    $this->error = 'Plan Name already exist.';
                    return true;
                }
                else {
                    return false;
                }
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }
}