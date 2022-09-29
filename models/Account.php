<?php
    class Account 
    {
        private $conn;
        private $table = 'account';

        # Properties

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create()
        {

        }

        # Get Account 
        public function read()
        {

        }

        # Update Account
        # Note: Assuming that lockin_end_date and billing_day may be updated by admin
        public function update() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET start_date = :start_date, 
                        lockin_end_date = :lockin_end_date, 
                        billing_day = :billing_day, 
                        created_at = current_timestamp(),
                        plan_id = :plan_id, 
                        connection_id = :connection_id, 
                        account_status_id = :account_status_id, 
                        area_id = :area_id,
                        bill_count = :bill_count
                    WHERE account_id = :account_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $this->start_date = htmlspecialchars(strip_tags($this->start_date));
            $this->lockin_end_date = htmlspecialchars(strip_tags($this->lockin_end_date));
            $this->billing_day = htmlspecialchars(strip_tags($this->billing_day));
            $this->plan_id = htmlspecialchars(strip_tags($this->plan_id));
            $this->connection_id = htmlspecialchars(strip_tags($this->connection_id));
            $this->account_status_id = htmlspecialchars(strip_tags($this->account_status_id));
            $this->area_id = htmlspecialchars(strip_tags($this->area_id));
            $this->bill_count = htmlspecialchars(strip_tags($this->bill_count));

            // Bind data
            $stmt->bindParam(':account_id', $this->account_id);
            $stmt->bindParam(':start_date', $this->start_date);
            $stmt->bindParam(':lockin_end_date', $this->lockin_end_date);
            $stmt->bindParam(':billing_day', $this->billing_day);
            $stmt->bindParam(':plan_id', $this->plan_id);
            $stmt->bindParam(':connection_id', $this->connection_id);
            $stmt->bindParam(':account_status_id', $this->account_status_id);
            $stmt->bindParam(':area_id', $this->area_id);
            $stmt->bindParam(':bill_count', $this->bill_count);
    
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

        # Delete Account
        # Note: Updated database table in ratings foreign key into delete cascade
        public function delete() 
        {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE account_id = :account_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            // Bind data
            $stmt->bindParam(':account_id', $this->account_id);

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