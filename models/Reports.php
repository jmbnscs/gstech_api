<?php
    class Reports 
    {
        private $conn;
        private $table;

        # Properties
        public $report_type;
        public $date_from;
        public $date_to;
        public $invoice_status;
        public $customer_status;
        public $customer_area;

        public $error;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Get Sales Report 
        public function read_sales()
        {
            $query = 'SELECT (SELECT payment_center FROM payment_centers WHERE center_id = p.payment_center)
                AS payment_center, payment_reference_id, payment_date, account_id, amount_paid 
                FROM payment AS p 
                WHERE payment_date 
                BETWEEN DATE_FORMAT(:date_from, "%Y-%m-01") AND LAST_DAY(:date_to)';
            
            $stmt = $this->conn->prepare($query);

            $this->formatDateString();

            $stmt->bindParam(':date_to', $this->date_to);
            $stmt->bindParam(':date_from', $this->date_from);

            $stmt->execute();

            return $stmt;
        }

        # Get Installation Report 
        public function read_installation()
        {
            $query = 'SELECT payment_reference_id, (SELECT payment_date FROM payment WHERE payment_reference_id = i.payment_reference_id) AS payment_date, account_id, installation_charge FROM invoice AS i WHERE invoice_status_id = 1 AND installation_charge > 0 AND payment_date BETWEEN DATE_FORMAT(:date_from, "%Y-%m-01") AND LAST_DAY(:date_to)';
            
            $stmt = $this->conn->prepare($query);

            $this->formatDateString();

            $stmt->bindParam(':date_to', $this->date_to);
            $stmt->bindParam(':date_from', $this->date_from);

            $stmt->execute();

            return $stmt;
        }

        public function read_prorates()
        {
            $query = 'SELECT DATE_FORMAT(updated_at, "%Y-%m-%d") AS date, invoice_id, account_id, duration, prorate_charge FROM prorate WHERE prorate_status_id = 2 AND updated_at BETWEEN DATE_FORMAT(:date_from, "%Y-%m-01") AND LAST_DAY(:date_to)';
            
            $stmt = $this->conn->prepare($query);

            $this->formatDateString();

            $stmt->bindParam(':date_to', $this->date_to);
            $stmt->bindParam(':date_from', $this->date_from);

            $stmt->execute();

            return $stmt;
        }

        # Get Customer Report 
        public function read_customers()
        {
            if ($this->customer_status == 0 && $this->customer_area == 0) {
                $query = 'SELECT a.start_date, c.account_id, c.gstech_id, c.first_name, c.last_name, c.billing_address, (SELECT plan_name FROM plan WHERE plan_id = a.plan_id) AS plan, (SELECT area_name FROM area WHERE area_id = a.area_id) AS area FROM customer as c INNER JOIN account as a ON c.account_id = a.account_id WHERE a.start_date BETWEEN DATE_FORMAT(:date_from, "%Y-%m-01") AND LAST_DAY(:date_to)';
            }
            else if ($this->customer_status != 0 && $this->customer_area != 0) {
                $query = 'SELECT a.start_date, c.account_id, c.gstech_id, c.first_name, c.last_name, c.billing_address, (SELECT plan_name FROM plan WHERE plan_id = a.plan_id) AS plan, (SELECT area_name FROM area WHERE area_id = a.area_id) AS area FROM customer as c INNER JOIN account as a ON c.account_id = a.account_id WHERE a.start_date BETWEEN DATE_FORMAT(:date_from, "%Y-%m-01") AND LAST_DAY(:date_to) AND a.area_id = :customer_area AND a.account_status_id = :customer_status';
            }
            else if ($this->customer_status == 0 && $this->customer_area != 0) {
                $query = 'SELECT a.start_date, c.account_id, c.gstech_id, c.first_name, c.last_name, c.billing_address, (SELECT plan_name FROM plan WHERE plan_id = a.plan_id) AS plan, (SELECT area_name FROM area WHERE area_id = a.area_id) AS area FROM customer as c INNER JOIN account as a ON c.account_id = a.account_id WHERE a.start_date BETWEEN DATE_FORMAT(:date_from, "%Y-%m-01") AND LAST_DAY(:date_to) AND a.area_id = :customer_area';
            }
            else if ($this->customer_status != 0 && $this->customer_area == 0) {
                $query = 'SELECT a.start_date, c.account_id, c.gstech_id, c.first_name, c.last_name, c.billing_address, (SELECT plan_name FROM plan WHERE plan_id = a.plan_id) AS plan, (SELECT area_name FROM area WHERE area_id = a.area_id) AS area FROM customer as c INNER JOIN account as a ON c.account_id = a.account_id WHERE a.start_date BETWEEN DATE_FORMAT(:date_from, "%Y-%m-01") AND LAST_DAY(:date_to) AND a.account_status_id = :customer_status';
            }

            $stmt = $this->conn->prepare($query);
            
            $this->formatDateString();

            $stmt->bindParam(':date_to', $this->date_to);
            $stmt->bindParam(':date_from', $this->date_from);

            if ($this->customer_status != 0 && $this->customer_area != 0) {
                $stmt->bindParam(':customer_status', $this->customer_status);
                $stmt->bindParam(':customer_area', $this->customer_area);
            }
            else if ($this->customer_status == 0 && $this->customer_area != 0) {
                $stmt->bindParam(':customer_area', $this->customer_area);
            }
            else if ($this->customer_status != 0 && $this->customer_area == 0) {
                $stmt->bindParam(':customer_status', $this->customer_status);
            }
            
            $stmt->execute();

            return $stmt;
        }

        # Get Invoice Report 
        public function read_invoice()
        {
            if ($this->invoice_status == 0) {
                $query = 'SELECT account_id, invoice_id, disconnection_date, running_balance, (SELECT first_name FROM customer WHERE account_id = i.account_id) AS first_name, (SELECT last_name FROM customer WHERE account_id = i.account_id) AS last_name FROM invoice AS i WHERE i.billing_period_start BETWEEN DATE_FORMAT(:date_from, "%Y-%m-01") AND LAST_DAY(:date_to)';
            }
            else {
                $query = 'SELECT account_id, invoice_id, disconnection_date, running_balance, (SELECT first_name FROM customer WHERE account_id = i.account_id) AS first_name, (SELECT last_name FROM customer WHERE account_id = i.account_id) AS last_name FROM invoice AS i WHERE i.billing_period_start BETWEEN DATE_FORMAT(:date_from, "%Y-%m-01") AND LAST_DAY(:date_to) AND i.invoice_status_id = :invoice_status';
            }
            
            $stmt = $this->conn->prepare($query);

            $this->formatDateString();

            $stmt->bindParam(':date_to', $this->date_to);
            $stmt->bindParam(':date_from', $this->date_from);

            if ($this->invoice_status != 0) {
                $stmt->bindParam(':invoice_status', $this->invoice_status);
            }

            $stmt->execute();

            return $stmt;
        }

        # Get Admin Logs Report 
        public function read_admin_logs()
        {
            $query = 'SELECT admin_id, username, page_accessed, activity, date_accessed FROM admin_logs WHERE date_accessed BETWEEN DATE_FORMAT(:date_from, "%Y-%m-01") AND LAST_DAY(:date_to) AND page_accessed != "Login" ORDER BY date_accessed DESC';
            
            $stmt = $this->conn->prepare($query);

            $this->formatDateString();

            $stmt->bindParam(':date_to', $this->date_to);
            $stmt->bindParam(':date_from', $this->date_from);

            $stmt->execute();

            return $stmt;
        }
        

        # Get Income Summary Report 
        public function read_income_summary()
        {
            $query = 'SELECT (SELECT SUM(amount_paid) FROM payment WHERE payment_date BETWEEN DATE_FORMAT(:date_from, "%Y-%m-01") AND LAST_DAY(:date_to)) AS sales, (SELECT SUM(total) FROM expenses) AS expenses, (SELECT SUM(installation_charge) FROM invoice WHERE billing_period_start BETWEEN DATE_FORMAT(:date_from, "%Y-%m-01") AND LAST_DAY(:date_to) AND invoice_status_id = 1) AS installation_sales, (SELECT SUM(prorate_charge) FROM prorate WHERE created_at BETWEEN DATE_FORMAT(:date_from, "%Y-%m-01") AND LAST_DAY(:date_to) AND prorate_status_id = 2) AS prorate_loss';
            
            $stmt = $this->conn->prepare($query);

            $this->formatDateString();

            $stmt->bindParam(':date_to', $this->date_to);
            $stmt->bindParam(':date_from', $this->date_from);

            $stmt->execute();

            

            return $stmt;
        }

        private function formatDateString() {
            $this->date_from = $this->date_from . '-01';
            $this->date_to = $this->date_to . '-01';
        }
    }