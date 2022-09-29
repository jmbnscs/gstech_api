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
        public function create()
        {

        }

        # Get Customer 
        public function read()
        {

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