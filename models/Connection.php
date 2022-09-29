<?php
    class Connection 
    {
        private $conn;
        private $table = 'connection';

        # Properties
        public $connection_id;
        public $connection_type;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create()
        {

        }

        # Get Connection 
        public function read()
        {

        }

        # Update Connection
        public function update()
        {

        }

        # Delete Connection
        public function delete()
        {
            
        }
    }