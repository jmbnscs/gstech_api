<?php
    class Concerns 
    {
        private $conn;
        private $table = 'concerns';

        # Properties
        public $concern_id;
        public $concern_category;
        public $admin_access;
        public $customer_access;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create()
        {

        }

        # Get Concerns 
        public function read()
        {

        }

        # Update Concerns
        public function update()
        {

        }

        # Delete Concerns
        public function delete()
        {
            
        }
    }