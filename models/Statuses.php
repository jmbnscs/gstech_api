<?php
    class Statuses 
    {
        private $conn;
        private $table;

        # Properties
        public $status_id;
        public $status_name;
        public $status_table;

        # Syntax for table name
        // $this->table = $this->status_table;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create()
        {

        }

        # Get Statuses 
        public function read()
        {

        }

        # Update Statuses
        public function update()
        {

        }

        # Delete Statuses
        public function delete()
        {
            
        }
    }