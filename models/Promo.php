<?php
    class Promo 
    {
        private $conn;
        private $table = 'promo';

        # Properties
        public $promo_id;
        public $netflix;
        public $fiber_switch;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create()
        {

        }

        # Get Promo 
        public function read()
        {

        }

        # Update Promo
        public function update()
        {

        }

        # Delete Promo
        public function delete()
        {
            
        }
    }