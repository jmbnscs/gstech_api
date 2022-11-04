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

        # Admin Details
        public function admin()
        {
            // Create Query
            $query = 'SELECT * FROM view_admin_details';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        # Payment Details
        public function payment()
        {
            // Create Query
            $query = 'SELECT * FROM view_payment_details';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        # Prorate Details
        public function prorate()
        {
            // Create Query
            $query = 'SELECT * FROM view_prorate_details';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        # Invoice Details
        public function invoice()
        {
            // Create Query
            $query = 'SELECT * FROM view_invoice_details';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }
    }