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
        public $prorate_id;
        public $account_id;

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

        public function customer_single()
        {
            // Create Query
            $query = 'SELECT * FROM customer WHERE account_id = :account_id';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':account_id', $this->account_id);

            $stmt->execute();

            return $stmt;
        }

        #Account Details
        public function account()
        {
            // Create Query
            $query = 'SELECT * FROM view_account_info';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function account_single()
        {
            // Create Query
            $query = 'SELECT * FROM view_account_info WHERE account_id = :account_id';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':account_id', $this->account_id);

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

        # Installation Details
        public function install_single()
        {
            // Create Query
            $query = 'SELECT * FROM view_account_install WHERE account_id = :account_id';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':account_id', $this->account_id);

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

        public function invoice_unpaid()
        {
            // Create Query
            $query = 'SELECT * FROM view_invoice_unpaid';
            
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

        public function prorate_single()
        {
            // Create Query
            $query = 'SELECT * FROM view_prorate_details WHERE prorate_id = :prorate_id';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':prorate_id', $this->prorate_id);

            $stmt->execute();

            return $stmt;
        }

        # Rating Details
        public function rating_single()
        {
            // Create Query
            $query = 'SELECT r.account_id, r.rating_base, r.delinquent_ratings, r.avg_rating, (SELECT status_name FROM ratings_status WHERE status_id = r.ratings_status_id) AS rating_status FROM ratings AS r WHERE account_id = :account_id';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':account_id', $this->account_id);

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
        
        # Pending Ticket Details
        public function ticket_pending()
        {
            // Create Query
            $query = 'SELECT * FROM ticket_pending_details';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }
    }