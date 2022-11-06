<?php
    class Admin 
    {
        private $conn;
        private $table = 'admin';

        # Properties
        public $admin_id;
        public $admin_username;
        public $admin_password;
        public $admin_email;
        public $mobile_number;
        public $first_name;
        public $middle_name;
        public $last_name;
        public $birthdate;
        public $address;
        public $employment_date;
        public $created_at;
        public $admin_status_id;
        public $user_level_id;
        public $login_attempts;
        public $hashed;

        public $message;
        public $error;
 
        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create()
        {
            // Create Query
            $query = 'INSERT INTO ' . 
                    $this->table . '
                SET
                    admin_id = :admin_id,
                    admin_username = admin_gen_un(:last_name, :first_name, :birthdate),
                    admin_password = admin_gen_pw(:last_name),
                    admin_email = :admin_email,
                    mobile_number = :mobile_number,
                    first_name = :first_name,
                    middle_name = :middle_name,
                    last_name = :last_name,
                    birthdate = :birthdate,
                    address = :address,
                    employment_date = :employment_date,
                    user_level_id = :user_level_id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));
            $this->admin_email = htmlspecialchars(strip_tags($this->admin_email));
            $this->mobile_number = htmlspecialchars(strip_tags($this->mobile_number));
            $this->first_name = htmlspecialchars(strip_tags($this->first_name));
            $this->middle_name = htmlspecialchars(strip_tags($this->middle_name));
            $this->last_name = htmlspecialchars(strip_tags($this->last_name));
            $this->birthdate = htmlspecialchars(strip_tags($this->birthdate));
            $this->address = htmlspecialchars(strip_tags($this->address));
            $this->employment_date = htmlspecialchars(strip_tags($this->employment_date));
            $this->user_level_id = htmlspecialchars(strip_tags($this->user_level_id));

            // Bind Data
            $stmt->bindParam(':admin_id', $this->admin_id);
            $stmt->bindParam(':admin_email', $this->admin_email);
            $stmt->bindParam(':mobile_number', $this->mobile_number);
            $stmt->bindParam(':first_name', $this->first_name);
            $stmt->bindParam(':middle_name', $this->middle_name);
            $stmt->bindParam(':last_name', $this->last_name);
            $stmt->bindParam(':birthdate', $this->birthdate);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':employment_date', $this->employment_date);
            $stmt->bindParam(':user_level_id', $this->user_level_id);

            // Execute Query
            try {
                $stmt->execute();
                return true;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }

        # Get Admin 
        public function read()
        {
            // Create Query
            $query = 'SELECT 
                *
            FROM
             ' . $this->table . ' 
            ORDER BY created_at DESC';
            
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
                admin_id = :admin_id';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':admin_id', $this->admin_id);

            // Execute Query
            $stmt->execute();

            return $stmt;
        }

        public function login () 
        {
            $query = 'SELECT *
                FROM ' . $this->table . ' 
            WHERE
                admin_username = :admin_username';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':admin_username', $this->admin_username);

            // Execute Query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            if (!$row) {
                $this->message = 'Invalid Credentials';
            }
            else
            {
                if ($row['admin_status_id'] !== 1 && $row['admin_status_id'] !== 3) {
                    $this->message = 'The account is restricted from logging in.';
                }
                else if ($row['admin_status_id'] === 3) {
                    $this->message = 'The account has been locked.';
                }
                else if ($row['admin_password'] === $this->admin_password)
                {
                    $this->admin_id = $row['admin_id'];
                    ($row['hashed'] === 0) ? $this->message = 'change password' : $this->message = 'success';
                    $this->update_attempts();
                }
                else if (password_verify($this->admin_password, $row['admin_password'])) {
                    $this->admin_id = $row['admin_id'];
                    ($row['hashed'] === 0) ? $this->message = 'change password' : $this->message = 'success';
                    $this->update_attempts();
                }
                else
                {
                    $this->update_add_attempts();
                    $login_attempts = $this->getLoginAttempts();
                    if ($login_attempts === 8) {
                        $this->update_locked_status();
                        $this->message = 'The account has been locked.';
                    }
                    else {
                        $this->login_attempts = $login_attempts;
                        $this->message = 'Invalid Password';
                    }
                }
            }
        }

        # Update Admin
        public function update() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET admin_email = :admin_email, 
                        mobile_number = :mobile_number, 
                        address = :address
                    WHERE admin_id = :admin_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->admin_email = htmlspecialchars(strip_tags($this->admin_email));
            $this->mobile_number = htmlspecialchars(strip_tags($this->mobile_number));
            $this->address = htmlspecialchars(strip_tags($this->address));
            $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));
    
            // Bind data
            $stmt->bindParam(':admin_email', $this->admin_email);
            $stmt->bindParam(':mobile_number', $this->mobile_number);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':admin_id', $this->admin_id);
    
            // Execute Query
            try {
                if ($this->isAccountExist()) {
                    $stmt->execute();
                    return true;
                }
                else {
                    $this->error = 'Admin ID does not exist.';
                    return false;
                }
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }

        private function update_add_attempts ()
        {
            // Create query
            $query = 'UPDATE ' . $this->table . ' 
                    SET login_attempts = (login_attempts + 1) 
                    WHERE admin_username = :admin_username;';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->admin_username = htmlspecialchars(strip_tags($this->admin_username));

            // Bind data
            $stmt->bindParam(':admin_username', $this->admin_username);

            $stmt->execute();
        }
        
        private function update_attempts ()
        {
            // Create query
            $query = 'UPDATE ' . $this->table . ' 
                     SET login_attempts = 0 
                     WHERE admin_username = :admin_username';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->admin_username = htmlspecialchars(strip_tags($this->admin_username));

            // Bind data
            $stmt->bindParam(':admin_username', $this->admin_username);

            $stmt->execute();
        }

        public function update_locked_status ()
        {
            // Create query
            $query = 'UPDATE ' . $this->table . ' 
                     SET admin_status_id = 3
                     WHERE admin_username = :admin_username';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->admin_username = htmlspecialchars(strip_tags($this->admin_username));

            // Bind data
            $stmt->bindParam(':admin_username', $this->admin_username);

            $stmt->execute();
        }

        public function update_password() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET admin_password = :admin_password,
                    hashed = 1
                    WHERE admin_id = :admin_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->admin_password = htmlspecialchars(strip_tags($this->admin_password));
            $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));

            // Hash Password
            $options = ['cost' => 12,];
            $this->admin_password = password_hash($this->admin_password, PASSWORD_BCRYPT, $options);
    
            // Bind data
            $stmt->bindParam(':admin_password', $this->admin_password);
            $stmt->bindParam(':admin_id', $this->admin_id);
    
            // Execute Query
            try {
                if ($this->isAccountExist()) {
                    $stmt->execute();
                    return true;
                }
                else {
                    $this->error = 'Admin ID does not exist.';
                    return false;
                }
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }

        public function verify_password()
        {
            $query = 'SELECT admin_password, hashed FROM ' . $this->table . ' WHERE admin_id = :admin_id';

            $stmt = $this->conn->prepare($query);

            $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));
            $stmt->bindParam(':admin_id', $this->admin_id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                $this->message = 'Admin ID does not exist.';
            }
            else if ($row['hashed'] == 0) {
                if ($this->admin_password == $row['admin_password']) {
                    return true;
                }
                else {
                    return false;
                }
            }
            else if (password_verify($this->admin_password, $row['admin_password'])){
                return true;
            }
            else {
                return false;
            }
        }

        public function update_status() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET 
                        admin_status_id = :admin_status_id,
                        login_attempts = 0
                    WHERE admin_id = :admin_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->admin_status_id = htmlspecialchars(strip_tags($this->admin_status_id));
            $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));
    
            // Bind data
            $stmt->bindParam(':admin_status_id', $this->admin_status_id);
            $stmt->bindParam(':admin_id', $this->admin_id);
    
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

        # Delete Admin
        public function delete() 
        {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE admin_id = :admin_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));

            // Bind data
            $stmt->bindParam(':admin_id', $this->admin_id);

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

        private function isAccountExist()
        {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE admin_id = :admin_id';

            $stmt = $this->conn->prepare($query);

            $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));
            $stmt->bindParam(':admin_id', $this->admin_id);

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

        private function getLoginAttempts()
        {
            $query = 'SELECT login_attempts FROM ' . $this->table . ' WHERE admin_username = :admin_username';

            $stmt = $this->conn->prepare($query);

            $this->admin_username = htmlspecialchars(strip_tags($this->admin_username));
            $stmt->bindParam(':admin_username', $this->admin_username);

            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row['login_attempts'];
        }
    }