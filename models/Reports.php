<?php
    class Reports 
    {
        private $conn;

        # Properties
        public $month;

        public $error;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Get total unpaid
        public function unpaid()
        {
            $query = "SELECT
                        DATE_FORMAT(billing_period_end, '%m-%Y') AS month,
                        COUNT(invoice_id) AS count,
                        SUM(total_bill) AS total
                    FROM
                        invoice
                    WHERE
                        invoice_status_id != '1' AND MONTH(billing_period_end) = :month
                    GROUP BY
                        MONTH(billing_period_end),
                        YEAR(billing_period_end)";
            
            $stmt = $this->conn->prepare($query);

            $this->month = htmlspecialchars(strip_tags($this->month));
            $stmt->bindParam(':month', $this->month);

            try {
                $stmt->execute();
                return $stmt;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
            }
        }

        # Get total paid
        public function paid()
        {
            $query = "SELECT
                        DATE_FORMAT(billing_period_end, '%m-%Y') AS month,
                        COUNT(invoice_id) AS count,
                        SUM(total_bill) AS total
                    FROM
                        invoice
                    WHERE
                        invoice_status_id = '1' AND MONTH(billing_period_end) = :month
                    GROUP BY
                        MONTH(billing_period_end),
                        YEAR(billing_period_end)";
            
            $stmt = $this->conn->prepare($query);

            $this->month = htmlspecialchars(strip_tags($this->month));
            $stmt->bindParam(':month', $this->month);

            try {
                $stmt->execute();
                return $stmt;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
            }
        }

        public function all_paid()
        {
            $query = "SELECT
                        DATE_FORMAT(billing_period_end, '%M %Y') AS month,
                        COUNT(invoice_id) AS count,
                        SUM(total_bill) AS total
                    FROM
                        invoice
                    WHERE
                        invoice_status_id = '1'
                    GROUP BY
                        MONTH(billing_period_end),
                        YEAR(billing_period_end)";
            
            $stmt = $this->conn->prepare($query);

            try {
                $stmt->execute();
                return $stmt;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
            }
        }

        public function all_unpaid()
        {
            $query = "SELECT
                        DATE_FORMAT(billing_period_end, '%M %Y') AS month,
                        COUNT(invoice_id) AS count,
                        SUM(total_bill) AS total
                    FROM
                        invoice
                    WHERE
                        invoice_status_id != '1'
                    GROUP BY
                        MONTH(billing_period_end),
                        YEAR(billing_period_end)";
            
            $stmt = $this->conn->prepare($query);

            try {
                $stmt->execute();
                return $stmt;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
            }
        }

        public function year_total()
        {
            $query = "SELECT 
                (SELECT DATE_FORMAT(billing_period_start, '%Y') FROM invoice ORDER BY billing_period_start DESC LIMIT 1) AS year, 
                (SELECT SUM(total_bill) FROM invoice WHERE invoice_status_id = '1') AS paid, 
                (SELECT SUM(total_bill) FROM invoice WHERE invoice_status_id != '1') AS unpaid";
            
            $stmt = $this->conn->prepare($query);

            try {
                $stmt->execute();
                return $stmt;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
            }
        }

        public function plan_overview()
        {
            $query = "SELECT p.plan_name, p.bandwidth, p.price, COUNT(a.plan_id) AS subscribers FROM plan AS p  LEFT JOIN account AS a ON p.plan_id = a.plan_id GROUP BY 1";
            
            $stmt = $this->conn->prepare($query);

            try {
                $stmt->execute();
                return $stmt;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
            }
        }
    }