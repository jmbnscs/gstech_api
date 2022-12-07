<?php
    class Restriction {
        private $conn;
        private $table;

        public $user_id;
        public $nav_id;
        public $restrict_access;

        // Restrict Pages
        public $dashboard_page;
        public $customer_page;
        public $customer_list;
        public $customer_add;
        public $customer_import;
        public $invoice_page;
        public $invoice_view;
        public $invoice_payment;
        public $invoice_prorate;
        public $invoice_payment_add;
        public $plan_page;
        public $plan_view;
        public $plan_add;
        public $ticket_page;
        public $ticket_active;
        public $ticket_pending;
        public $ticket_resolved;
        public $ticket_invalid;
        public $ticket_create;
        public $admin_page;
        public $admin_view;
        public $admin_add;
        public $misc_page;
        public $profile_page;

        // Restrict Buttons
        public $invoice_edit;
        public $payments_edit;
        public $payments_dlt;
        public $prorate_edit;
        public $prorate_dlt;
        public $plans_edit;
        public $active_claim;
        public $active_invalid;
        public $pending_resolve;
        public $pending_invalid;
        public $invalid_reactivate;
        public $invalid_delete;
        public $custdata_edit;
        public $admindata_edit;
        public $admindata_reset;

        public $error;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function get_user_restriction () 
        {
            $query = 'SELECT * FROM restriction WHERE user_id = :user_id';

            $stmt = $this->conn->prepare($query);
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $stmt->bindParam(':user_id', $this->user_id);

            try {
                $stmt->execute();
                return $stmt;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
            }
        }

        public function get_pages_restriction () {
            $query = 'SELECT * FROM restrict_pages WHERE user_id = :user_id';

            $stmt = $this->conn->prepare($query);
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $stmt->bindParam(':user_id', $this->user_id);

            try {
                $stmt->execute();
                return $stmt;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
            }
        }

        public function get_buttons_restriction () {
            $query = 'SELECT * FROM restrict_buttons WHERE user_id = :user_id';

            $stmt = $this->conn->prepare($query);
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $stmt->bindParam(':user_id', $this->user_id);

            try {
                $stmt->execute();
                return $stmt;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
            }
        }
    }