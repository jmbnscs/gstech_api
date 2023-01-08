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
        public $status_name;
        public $user_role;

        public $plan_name;
        public $connection_name;
        public $install_type_name;
        public $area_name;
        public $install_status;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Customer Details
        public function customer()
        {
            // Create Query
            $query = 'SELECT * FROM customer_details ORDER BY start_date DESC';
            
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
            $query = 'SELECT * FROM view_prorate_details WHERE status = "Untagged"';
            
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

        # Invalid Ticket Details
        public function ticket_invalid()
        {
            // Create Query
            $query = 'SELECT * FROM ticket_invalid_details';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        # Get Import IDs
        public function getImportIDs()
        {
            $query = "SELECT (SELECT plan_id FROM plan WHERE plan_name = :plan_name) AS plan_id, (SELECT connection_id FROM connection WHERE connection_name = :connection_name) AS connection_id, (SELECT area_id FROM area WHERE area_name = :area_name) AS area_id, (SELECT install_type_id FROM installation_type WHERE install_type_name = :install_type_name) AS install_type_id, (SELECT status_id FROM installation_status WHERE status_name = :install_status) AS install_status_id";
            
            $stmt = $this->conn->prepare($query);

            $this->plan_name = htmlspecialchars(strip_tags($this->plan_name));
            $this->connection_name = htmlspecialchars(strip_tags($this->connection_name));
            $this->area_name = htmlspecialchars(strip_tags($this->area_name));
            $this->install_type_name = htmlspecialchars(strip_tags($this->install_type_name));
            $this->install_status = htmlspecialchars(strip_tags($this->install_status));

            $stmt->bindParam(':plan_name', $this->plan_name);
            $stmt->bindParam(':connection_name', $this->connection_name);
            $stmt->bindParam(':area_name', $this->area_name);
            $stmt->bindParam(':install_type_name', $this->install_type_name);
            $stmt->bindParam(':install_status', $this->install_status);

            $stmt->execute();
            return $stmt;

        }

        # Admin Details
        public function admin_user_level()
        {
            // Create Query
            $query = 'SELECT * FROM view_admin_details WHERE role = :user_role';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':user_role', $this->user_role);

            $stmt->execute();

            return $stmt;
        }

        #Export Account Details
        public function customer_export()
        {
            // Create Query
            $query = 'SELECT * FROM view_export_accounts';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }
    }