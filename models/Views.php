<?php
    class Views 
    {
        private $conn;

        # Properties
        public $view;
        public $promo_id;
        public $plan_id;
        public $inclusion_id;
        public $inclusion_code;

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

        # Plan Details
        public function plan_inclusions()
        {
            // Create Query
            $query = 'SELECT * FROM view_plan_inclusions 
                    WHERE
                plan_id = :plan_id';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':plan_id', $this->plan_id);

            // Execute Query
            $stmt->execute();

            return $stmt;
        }
    }