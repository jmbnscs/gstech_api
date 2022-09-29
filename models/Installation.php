<?php
    class Installation 
    {
        private $conn;
        private $table = 'installation';

        # Properties
        public $install_type_id;
        public $installation_total_charge;
        public $installation_balance;
        public $installment;
        public $account_id;
        public $installation_status_id;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create()
        {

        }

        # Get Installation 
        public function read()
        {

        }

        # Update Installation
        public function update()
        {

        }

        # Delete Installation
        public function delete()
        {
            
        }
    }