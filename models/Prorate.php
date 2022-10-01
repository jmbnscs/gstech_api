<?php
    class Prorate 
    {
        private $conn;
        private $table = 'prorate';

        # Properties
        public $prorate_id;
        public $duration;
        public $rate_per_minute;
        public $prorate_charge;
        public $account_id;
        public $invoice_id;
        public $prorate_status_id;

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
                    duration = :duration,
                    rate_per_minute = (SELECT rate_per_minute FROM plan WHERE plan_id = (SELECT plan_id FROM account WHERE account_id = :account_id)),
                    prorate_charge = prorate_gen_prorate_charge(:duration, rate_per_minute),
                    account_id = :account_id,
                    invoice_id = NULL';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->duration = htmlspecialchars(strip_tags($this->duration));
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            // Bind Data
            $stmt->bindParam(':duration', $this->duration);
            $stmt->bindParam(':account_id', $this->account_id);

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

        # Get Prorate 
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

        # Update Prorate
        public function update() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET duration = :duration, 
                        rate_per_minute = (SELECT rate_per_minute FROM plan WHERE plan_id = (SELECT plan_id FROM account WHERE account_id = :account_id)), 
                        prorate_charge = prorate_gen_prorate_charge(:duration, rate_per_minute), 
                        account_id = :account_id
                    WHERE prorate_id = :prorate_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->duration = htmlspecialchars(strip_tags($this->duration));
            $this->rate_per_minute = htmlspecialchars(strip_tags($this->rate_per_minute));
            $this->prorate_charge = htmlspecialchars(strip_tags($this->prorate_charge));
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $this->prorate_id = htmlspecialchars(strip_tags($this->prorate_id));
    
            // Bind data
            $stmt->bindParam(':duration', $this->duration);
            $stmt->bindParam(':rate_per_minute', $this->rate_per_minute);
            $stmt->bindParam(':prorate_charge', $this->prorate_charge);
            $stmt->bindParam(':account_id', $this->account_id);
            $stmt->bindParam(':prorate_id', $this->prorate_id);
    
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

        # Delete Prorate
        public function delete() 
        {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE prorate_id = :prorate_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->prorate_id = htmlspecialchars(strip_tags($this->prorate_id));

            // Bind data
            $stmt->bindParam(':prorate_id', $this->prorate_id);

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