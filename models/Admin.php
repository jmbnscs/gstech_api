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

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create()
        {

        }

        # Get Admin 
        public function read()
        {

        }

        # Update Admin
        public function update()
        {

        }

        # Delete Admin
        public function delete()
        {
            
        }
    }