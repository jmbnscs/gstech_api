<?php
    class Customer 
    {
        private $conn;
        private $table = 'customer';

        # Properties
        public $account_id;
        public $first_name;
        public $middle_name;
        public $last_name;
        public $billing_address;
        public $mobile_number;
        public $email;
        public $birthdate;
        public $gstech_id;
        public $customer_username;
        public $customer_password;
        public $user_level_id;

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
                    account_id = :account_id,
                    first_name = :first_name,
                    middle_name = :middle_name,
                    last_name = :last_name,
                    billing_address = :billing_address,
                    mobile_number = :mobile_number,
                    email = :email,
                    birthdate = :birthdate,
                    gstech_id = customer_gen_gstech_id(:last_name, :first_name),
                    customer_username = customer_gen_username(:last_name, :first_name, :birthdate),
                    customer_password = customer_gen_password(:last_name)';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $this->first_name = htmlspecialchars(strip_tags($this->first_name));
            $this->middle_name = htmlspecialchars(strip_tags($this->middle_name));
            $this->last_name = htmlspecialchars(strip_tags($this->last_name));
            $this->billing_address = htmlspecialchars(strip_tags($this->billing_address));
            $this->mobile_number = htmlspecialchars(strip_tags($this->mobile_number));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->birthdate = htmlspecialchars(strip_tags($this->birthdate));

            // Bind Data
            $stmt->bindParam(':account_id', $this->account_id);
            $stmt->bindParam(':first_name', $this->first_name);
            $stmt->bindParam(':middle_name', $this->middle_name);
            $stmt->bindParam(':last_name', $this->last_name);
            $stmt->bindParam(':billing_address', $this->billing_address);
            $stmt->bindParam(':mobile_number', $this->mobile_number);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':birthdate', $this->birthdate);

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

        # Get Customer 
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

        # Update Customer
        public function update()
        {

        }

        # Delete Customer
        public function delete()
        {
            
        }
    }