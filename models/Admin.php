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

        public $message;
 
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
                    admin_id = admin_gen_id(),
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
            // $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));
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
            // $stmt->bindParam(':admin_id', $this->admin_id);
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

        # Get Admin 
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
                admin_id = :admin_id';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':admin_id', $this->admin_id);

            // Execute Query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->admin_id = $row['admin_id'];
            $this->admin_username = $row['admin_username'];
            $this->admin_password = $row['admin_password'];
            $this->admin_email = $row['admin_email'];
            $this->mobile_number = $row['mobile_number'];
            $this->first_name = $row['first_name'];
            $this->middle_name = $row['middle_name'];
            $this->last_name = $row['last_name'];
            $this->birthdate = $row['birthdate'];
            $this->address = $row['address'];
            $this->employment_date = $row['employment_date'];
            $this->created_at = $row['created_at'];
            $this->admin_status_id = $row['admin_status_id'];
            $this->user_level_id = $row['user_level_id'];
        }

        public function login () 
        {
            $query = 'SELECT
                * FROM ' . 
            $this->table . ' 
            WHERE
                admin_username = :admin_username';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':admin_username', $this->admin_username);

            // Execute Query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->message = $row;

            // Set Properties
            if (!$row) {
                $this->message = 'failed';
            }
            else {
                $this->admin_id = $row['admin_id'];
                $this->admin_username = $row['admin_username'];
                $this->admin_password = $row['admin_password'];
                $this->message = 'success';
            }

            // $this->admin_id = $row['admin_id'];
            // $this->admin_username = $row['admin_username'];
            // $this->admin_password = $row['admin_password'];
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
            // $this->admin_status_id = htmlspecialchars(strip_tags($this->admin_status_id));
            // $this->user_level_id = htmlspecialchars(strip_tags($this->user_level_id));
            $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));
    
            // Bind data
            $stmt->bindParam(':admin_email', $this->admin_email);
            $stmt->bindParam(':mobile_number', $this->mobile_number);
            $stmt->bindParam(':address', $this->address);
            // $stmt->bindParam(':admin_status_id', $this->admin_status_id);
            // $stmt->bindParam(':user_level_id', $this->user_level_id);
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

        public function update_status() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET admin_status_id = :admin_status_id
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

        public function isAdminIDExists ($admin_id)
        {
            $stmt = $this->conn->prepare('SELECT * FROM admin WHERE admin_id = ?;');
    
            if (!$stmt->execute(array($admin_id)))
            {
                $stmt = null;
            }
    
            if ($stmt->rowCount() == 0)
            {
                return false;
            }
    
            $stmt = null;
        }

        public function generateAdminID () 
        {
            $result = true;
            while ($result) {
                $admin_id = mt_rand(10000, 99999);
                $result = $this->isAdminIDExists($admin_id);
            } 
            
            return $admin_id;
        }
    }