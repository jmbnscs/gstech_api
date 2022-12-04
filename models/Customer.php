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

        public $login_username;
        public $message;

        public $account_status_id;
        
        public $error;

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

            try {
                $stmt->execute();
                return true;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
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
            $this->account_id = $row['account_id'];
            $this->first_name = $row['first_name'];
            $this->middle_name = $row['middle_name'];
            $this->last_name = $row['last_name'];
            $this->billing_address = $row['billing_address'];
            $this->mobile_number = $row['mobile_number'];
            $this->email = $row['email'];
            $this->birthdate = $row['birthdate'];
            $this->gstech_id = $row['gstech_id'];
            $this->customer_username = $row['customer_username'];
            $this->customer_password = $row['customer_password'];
            $this->user_level_id = $row['user_level_id'];
        }

        # Customer Login
        public function login()
        {
            $query = 'SELECT
                * FROM ' . 
            $this->table . ' 
            WHERE
                account_id = :login_username OR 
                customer_username = :login_username';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':login_username', $this->login_username);

            // Execute Query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->account_status_id = $this->getAccountStatus();

            // Set Properties
            if (!$row)
            {
                $this->message = 'Invalid Credentials';
            }
            else
            {
                if ($this->account_status_id === 2) 
                {
                    $this->message = 'The account is restricted from logging in.';
                }
                else if ($row['customer_password'] === $this->customer_password)
                {
                    $this->account_id = $row['account_id'];
                    ($row['pw_changed'] === 0) ? $this->message = 'change password' : $this->message = 'success';
                }
                else if (password_verify($this->customer_password, $row['customer_password'])) {
                    $this->account_id = $row['account_id'];
                    ($row['pw_changed'] === 0) ? $this->message = 'change password' : $this->message = 'success';
                }
                else
                {
                    $this->message = 'Incorrect Password';
                }
            }
        }

        # Update Customer
        public function update()
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET billing_address = :billing_address, 
                        mobile_number = :mobile_number, 
                        email = :email
                    WHERE account_id = :account_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $this->billing_address = htmlspecialchars(strip_tags($this->billing_address));
            $this->mobile_number = htmlspecialchars(strip_tags($this->mobile_number));
            $this->email = htmlspecialchars(strip_tags($this->email));

            // Bind data
            $stmt->bindParam(':account_id', $this->account_id);
            $stmt->bindParam(':billing_address', $this->billing_address);
            $stmt->bindParam(':mobile_number', $this->mobile_number);
            $stmt->bindParam(':email', $this->email);
    
            // Execute query
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

        # Delete Customer
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

        public function update_password() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET customer_password = :customer_password,
                    pw_changed = 1
                    WHERE account_id = :account_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->customer_password = htmlspecialchars(strip_tags($this->customer_password));
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            // Hash Password
            $options = ['cost' => 12,];
            $this->customer_password = password_hash($this->customer_password, PASSWORD_BCRYPT, $options);
    
            // Bind data
            $stmt->bindParam(':customer_password', $this->customer_password);
            $stmt->bindParam(':account_id', $this->account_id);
    
            // Execute Query
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

        public function verify_password()
        {
            $query = 'SELECT customer_password, pw_changed FROM ' . $this->table . ' WHERE account_id = :account_id';

            $stmt = $this->conn->prepare($query);

            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $stmt->bindParam(':account_id', $this->account_id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                $this->message = 'Account ID does not exist.';
            }
            else if ($row['pw_changed'] == 0) {
                if ($this->customer_password == $row['customer_password']) {
                    return true;
                }
                else {
                    return false;
                }
            }
            else if (password_verify($this->customer_password, $row['customer_password'])){
                return true;
            }
            else {
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

        private function getAccountStatus()
        {
            $query = 'SELECT a.account_status_id 
            FROM account a JOIN customer c ON a.account_id = c.account_id 
            WHERE a.account_id = :login_username OR customer_username = :login_username';

            $stmt = $this->conn->prepare($query);

            $this->login_username = htmlspecialchars(strip_tags($this->login_username));

            $stmt->bindParam(':login_username', $this->login_username);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($row) {
                return $row['account_status_id'];
            }
        }
    }