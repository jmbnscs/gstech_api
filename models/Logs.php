<?php
    class Logs {
        private $conn;
        private $table;

        public $admin_id;
        public $username;
        public $activity;
        public $ip_address;
        public $user_agent;


        public $account_id;
        public $invoice_id;
        public $email_sent;
        public $status_id;
        public $date_accessed;
        public $today_date;

        public $error;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function log_email() {
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $this->invoice_id = htmlspecialchars(strip_tags($this->invoice_id));
            $this->email_sent = htmlspecialchars(strip_tags($this->email_sent));
            $this->status_id = htmlspecialchars(strip_tags($this->status_id));

            $query = '
                INSERT INTO email_logs SET 
                    account_id = :account_id,
                    invoice_id = :invoice_id,
                    email_sent = :email_sent,
                    status_id = :status_id
            ';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':account_id', $this->account_id);
            $stmt->bindParam(':invoice_id', $this->invoice_id);
            $stmt->bindParam(':email_sent', $this->email_sent);
            $stmt->bindParam(':status_id', $this->status_id);

            try {
                $stmt->execute();
                return true;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }

        public function read_email_log() {
            // $this->invoice_id = htmlspecialchars(strip_tags($this->invoice_id));

            $query = '
                SELECT * FROM email_logs;
            ';

            $stmt = $this->conn->prepare($query);

            // $stmt->bindParam(':invoice_id', $this->invoice_id);

            $stmt->execute();

            return $stmt;
        }

        public function isSent() {
            $this->invoice_id = htmlspecialchars(strip_tags($this->invoice_id));
            $this->status_id = htmlspecialchars(strip_tags($this->status_id));
            $this->today_date = htmlspecialchars(strip_tags($this->today_date));

            $query = '
                SELECT * FROM email_logs WHERE invoice_id = :invoice_id AND status_id = :status_id AND date_accessed = :today_date;
            ';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':invoice_id', $this->invoice_id);
            $stmt->bindParam(':status_id', $this->status_id);
            $stmt->bindParam(':today_date', $this->today_date);

            $stmt->execute();

            $num = $stmt->rowCount();

            if ($num > 0) {
                return true;
            }
            else {
                return false;
            }
        }

        public function log_activity() {
            $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->page_accessed = htmlspecialchars(strip_tags($this->page_accessed));
            $this->activity = htmlspecialchars(strip_tags($this->activity));
            $this->ip_address = htmlspecialchars(strip_tags($this->ip_address));
            $this->user_agent = htmlspecialchars(strip_tags($this->user_agent));

            $query = '
                INSERT INTO admin_logs SET 
                    admin_id = :admin_id,
                    username = :username,
                    page_accessed = :page_accessed,
                    activity = :activity,
                    ip_address = :ip_address,
                    user_agent = :user_agent
            ';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':admin_id', $this->admin_id);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':page_accessed', $this->page_accessed);
            $stmt->bindParam(':activity', $this->activity);
            $stmt->bindParam(':ip_address', $this->ip_address);
            $stmt->bindParam(':user_agent', $this->user_agent);

            try {
                $stmt->execute();
                return true;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }

        public function read_activity_log() {
            $query = '
                SELECT * FROM admin_logs;
            ';

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }
    }