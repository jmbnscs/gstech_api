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
            if ($stmt->execute())
            {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
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

        # Update Installation
        public function update() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET install_type_id = :install_type_id, 
                        account_id = :account_id,
                        installation_status_id = :installation_status_id
                    WHERE installation_id = :installation_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->install_type_id = htmlspecialchars(strip_tags($this->install_type_id));
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $this->installation_status_id = htmlspecialchars(strip_tags($this->installation_status_id));
            $this->installation_id = htmlspecialchars(strip_tags($this->installation_id));
    
            // Bind data
            $stmt->bindParam(':install_type_id', $this->install_type_id);
            $stmt->bindParam(':account_id', $this->account_id);
            $stmt->bindParam(':installation_status_id', $this->installation_status_id);
            $stmt->bindParam(':installation_id', $this->installation_id);
    
            # will need to call procedure

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
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE installation_id = :installation_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->installation_id = htmlspecialchars(strip_tags($this->installation_id));

            // Bind data
            $stmt->bindParam(':installation_id', $this->installation_id);

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