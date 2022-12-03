<?php
    class Installation 
    {
        private $conn;
        private $table = 'installation';

        # Properties
        public $install_type_id;
        public $installation_total_charge;
        public $installation_balance;
        public $installment;
        public $account_id;
        public $installation_status_id;

        public $amount_paid;
        public $error;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create ()
        {
            // Clean Data
            $this->install_type_id = htmlspecialchars(strip_tags($this->install_type_id));

            if ($this->install_type_id === 2 || $this->install_type_id === "2")
            {
                $this->installation_total_charge = 1200;
                $this->installation_balance = 1200;
                $this->installment = 6;
                $this->installation_status_id = 2;
            }
            else
            {
                $this->installation_total_charge = 0;
                $this->installation_balance = 0;
                $this->installment = 0;
                $this->installation_status_id = 1;
            }

            $this->installation_total_charge = htmlspecialchars(strip_tags($this->installation_total_charge));
            $this->installation_balance = htmlspecialchars(strip_tags($this->installation_balance));
            $this->installment = htmlspecialchars(strip_tags($this->installment));
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $this->installation_status_id = htmlspecialchars(strip_tags($this->installation_status_id));

            // Create Query
            $query = 'INSERT INTO ' . 
                    $this->table . '
                SET
                    install_type_id = :install_type_id,
                    installation_total_charge = :installation_total_charge,
                    installation_balance = :installation_balance,
                    installment = :installment,
                    account_id = :account_id,
                    installation_status_id = :installation_status_id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind Data
            $stmt->bindParam(':install_type_id', $this->install_type_id);
            $stmt->bindParam(':installation_total_charge', $this->installation_total_charge);
            $stmt->bindParam(':installation_balance', $this->installation_balance);
            $stmt->bindParam(':installment', $this->installment);
            $stmt->bindParam(':account_id', $this->account_id);
            $stmt->bindParam(':installation_status_id', $this->installation_status_id);

            // Execute Query
            try {
                $stmt->execute();
                return true;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }

        # Get Installation 
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
                account_id = :account_id';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':account_id', $this->account_id);

            // Execute Query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->install_type_id = $row['install_type_id'];
            $this->installation_total_charge = $row['installation_total_charge'];
            $this->installation_balance = $row['installation_balance'];
            $this->installment = $row['installment'];
            $this->account_id = $row['account_id'];
            $this->installation_status_id = $row['installation_status_id'];
        }

        # Update Installation
        # Note: Changed the install_update_balance proc first into 'temp_balance - 200'
        public function update() 
        {
            // Create query
            $query = 'CALL install_update_balance(:account_id, :amount_paid)';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $this->amount_paid = htmlspecialchars(strip_tags($this->amount_paid));
    
            // Bind data
            $stmt->bindParam(':account_id', $this->account_id);
            $stmt->bindParam(':amount_paid', $this->amount_paid);

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

        # Delete Installation
        public function delete()
        {
            $query = 'DELETE FROM ' . $this->table . ' WHERE account_id = :account_id';

            $stmt = $this->conn->prepare($query);

            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            $stmt->bindParam(':account_id', $this->account_id);

            try {
                if ($this->isAccountExist()) {
                    $stmt->execute();
                    return true;
                }
                else {
                    $this->error = 'Account ID does not exist.';
                    return false;
                }
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }

        private function isAccountExist()
        {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE account_id = :account_id';

            $stmt = $this->conn->prepare($query);

            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $stmt->bindParam(':account_id', $this->account_id);

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