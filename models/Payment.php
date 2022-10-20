<?php
    class Payment 
    {
        // DB Stuff
        private $conn;
        private $table = 'payment';

        // Properties
        public $payment_id;
        public $amount_paid;
        public $payment_reference_id;
        public $account_id;
        public $invoice_id;
        public $tagged;

        // Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create ()
        {
            // Clean Data
            $this->amount_paid = htmlspecialchars(strip_tags($this->amount_paid));
            $this->payment_reference_id = htmlspecialchars(strip_tags($this->payment_reference_id));

            // Create Query
            $query = 'INSERT INTO ' . 
                    $this->table . '
                SET
                    amount_paid = :amount_paid,
                    payment_reference_id = :payment_reference_id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind Data
            $stmt->bindParam(':amount_paid', $this->amount_paid);
            $stmt->bindParam(':payment_reference_id', $this->payment_reference_id);

            // Execute Query
            if ($stmt->execute())
            {
                $this->getID();
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
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

        public function read_single () 
        {
            $query = 'SELECT
                * FROM ' . 
            $this->table . ' 
            WHERE
                payment_id = :payment_id';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':payment_id', $this->payment_id);

            // Execute Query
            $stmt->execute();

            return $stmt;
        }

        # Update Plan
        public function update() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET amount_paid = :amount_paid, 
                        payment_reference_id = :payment_reference_id
                    WHERE payment_id = :payment_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->amount_paid = htmlspecialchars(strip_tags($this->amount_paid));
            $this->payment_reference_id = htmlspecialchars(strip_tags($this->payment_reference_id));
            $this->payment_id = htmlspecialchars(strip_tags($this->payment_id));
    
            // Bind data
            $stmt->bindParam(':amount_paid', $this->amount_paid);
            $stmt->bindParam(':payment_reference_id', $this->payment_reference_id);
            $stmt->bindParam(':payment_id', $this->payment_id);
    
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

        public function update_tagged() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET account_id = :account_id, 
                        invoice_id = :invoice_id,
                        tagged = 1
                    WHERE payment_id = :payment_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $this->invoice_id = htmlspecialchars(strip_tags($this->invoice_id));
            $this->payment_id = htmlspecialchars(strip_tags($this->payment_id));
    
            // Bind data
            $stmt->bindParam(':account_id', $this->account_id);
            $stmt->bindParam(':invoice_id', $this->invoice_id);
            $stmt->bindParam(':payment_id', $this->payment_id);
    
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
            $query = 'DELETE FROM ' . $this->table . ' WHERE payment_id = :payment_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->payment_id = htmlspecialchars(strip_tags($this->payment_id));

            // Bind data
            $stmt->bindParam(':payment_id', $this->payment_id);

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
            $query = 'SELECT plan_get_created_id() AS payment_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->payment_id = $row['payment_id'];
        }
}