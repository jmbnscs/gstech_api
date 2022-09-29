<?php
    class Prorate 
    {
        private $conn;
        private $table = 'prorate';

        # Properties
        public $prorate_id;
        public $duration;
        public $rate_per_minute;
        public $prorate_charge;
        public $account_id;
        public $invoice_id;
        public $prorate_status_id;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create()
        {

        }

        # Get Prorate 
        public function read()
        {

        }

        # Update Prorate
        public function update()
        {

        }

        # Delete Prorate
        public function delete()
        {
            
        }
    }