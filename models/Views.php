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

        # Ticket Details
        public function ticket()
        {
            // Create Query
            $query = 'SELECT * FROM ticket_details';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        # Resolved Ticket Details
        public function ticket_resolved()
        {
            // Create Query
            $query = 'SELECT * FROM ticket_resolved_details';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        # Plan Details
        public function plan()
        {
            // Create Query
            $query = 'SELECT * FROM plan_details';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }
    }