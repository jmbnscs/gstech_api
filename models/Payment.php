<?php
    class Payment 
    {
        private $conn;
        private $table = 'payment';

        public $payment_id;
        public $amount_paid;
        public $payment_reference_id;
        public $account_id;
        public $invoice_id;
        public $tagged;

        public $error;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create ()
        {
            $this->amount_paid = htmlspecialchars(strip_tags($this->amount_paid));
            $this->payment_reference_id = htmlspecialchars(strip_tags($this->payment_reference_id));
            $this->payment_date = htmlspecialchars(strip_tags($this->payment_date));

            $query = 'INSERT INTO ' . 
                    $this->table . '
                SET
                    amount_paid = :amount_paid,
                    payment_reference_id = :payment_reference_id,
                    payment_date = :payment_date';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':amount_paid', $this->amount_paid);
            $stmt->bindParam(':payment_reference_id', $this->payment_reference_id);
            $stmt->bindParam(':payment_date', $this->payment_date);

            try {
                $stmt->execute();
                $this->payment_id = $this->conn->lastInsertId();
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

        public function read_single_account () 
        {
            $query = 'SELECT
                * FROM ' . 
            $this->table . ' 
            WHERE account_id = :account_id';

            $stmt = $this->conn->prepare($query);
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $stmt->bindParam(':account_id', $this->account_id);

            $stmt->execute();

            return $stmt;
        }

        public function read_untagged () {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE tagged = 0';

            $stmt = $this->conn->prepare($query);
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
            $query = 'DELETE FROM ' . $this->table . ' WHERE payment_id = :payment_id';

            $stmt = $this->conn->prepare($query);

            $this->payment_id = htmlspecialchars(strip_tags($this->payment_id));

            $stmt->bindParam(':payment_id', $this->payment_id);

            try {
                if ($this->isPaymentIDExist()) {
                    $stmt->execute();
                    return true;
                }
                else {
                    $this->error = 'Payment ID does not exist.';
                    return false;
                }
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }

        // Get ID of newly created payment record
        private function getID()
        {
            // Create query
            $query = 'SELECT LAST_INSERT_ID() AS payment_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->payment_id = $row['payment_id'];
        }

        private function isPaymentIDExist()
        {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE payment_id = :payment_id';

            $stmt = $this->conn->prepare($query);

            $this->payment_id = htmlspecialchars(strip_tags($this->payment_id));
            $stmt->bindParam(':payment_id', $this->payment_id);

            try {
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row) {
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

        public function isPayRefExist()
        {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE payment_reference_id = :payment_reference_id';

            $stmt = $this->conn->prepare($query);

            $this->payment_reference_id = htmlspecialchars(strip_tags($this->payment_reference_id));
            $stmt->bindParam(':payment_reference_id', $this->payment_reference_id);

            try {
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row) {
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