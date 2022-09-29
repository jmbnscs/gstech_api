<?php
    class InstallationType 
    {
        private $conn;
        private $table = 'installation_type';

        # Properties
        public $install_type_id;
        public $install_type_name;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create()
        {

        }

        # Get InstallationType 
        public function read()
        {

        }

        # Update InstallationType
        public function update()
        {

        }

        # Delete InstallationType
        public function delete()
        {
            
        }
    }