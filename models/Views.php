<?php
    class Views 
    {
        private $conn;

        # Properties
        public $view;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Customer Details
        public function customer()
        {
            // Create Query
            $query = 'SELECT * FROM customer_details';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }
    }