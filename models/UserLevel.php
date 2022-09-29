<?php
    class UserLevel 
    {
        private $conn;
        private $table = 'user_level';

        # Properties
        public $user_id;
        public $user_role;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create()
        {

        }

        # Get UserLevel 
        public function read()
        {

        }

        # Update UserLevel
        public function update()
        {

        }

        # Delete UserLevel
        public function delete()
        {
            
        }
    }