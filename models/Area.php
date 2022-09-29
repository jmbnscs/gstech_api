<?php
    class Area 
    {
        private $conn;
        private $table = 'area';

        # Properties
        public $area_id;
        public $area_name;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create()
        {

        }

        # Get Area 
        public function read()
        {

        }

        # Update Area
        public function update()
        {

        }

        # Delete Area
        public function delete()
        {
            
        }
    }