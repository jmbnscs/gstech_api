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
            
        }

        # Delete Prorate
        public function delete()
        {
            
        }
    }