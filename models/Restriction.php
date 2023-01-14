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
        public $plans_add;
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
        public $admins_add;
        public $tickets_add;

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

        public function update_pages_restriction () {
            $query = 'UPDATE restrict_pages 
                SET customer_page = :customer_page,
                    customer_list = :customer_list,
                    customer_add = :customer_add,
                    customer_import = :customer_import,
                    invoice_page = :invoice_page,
                    invoice_view = :invoice_view,
                    invoice_payment = :invoice_payment,
                    invoice_prorate = :invoice_prorate,
                    invoice_payment_add = :invoice_payment_add,
                    plan_page = :plan_page,
                    plan_view = :plan_view,
                    ticket_page = :ticket_page,
                    ticket_active = :ticket_active,
                    ticket_pending = :ticket_pending,
                    ticket_invalid = :ticket_invalid,
                    admin_page = :admin_page,
                    admin_view = :admin_view
             WHERE user_id = :user_id';

            $stmt = $this->conn->prepare($query);
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));

            // Customer Page Restrictions
            $this->customer_list = htmlspecialchars(strip_tags($this->customer_list));
            if ($this->customer_list == 1) {
                $this->customer_page = 1;
                $this->customer_add = htmlspecialchars(strip_tags($this->customer_add));
                ($this->customer_add == 1) ? $this->customer_import = 1 : $this->customer_import = 0;
            }
            else {
                $this->customer_page = 0;
                $this->customer_add = 0;
                $this->customer_import = 0;
            }

            // Invoice Page Restrictions
            $this->invoice_view = htmlspecialchars(strip_tags($this->invoice_view));
            ($this->invoice_view == 1) ? $this->invoice_page = 1 : $this->invoice_page = 0;

            $this->invoice_payment = htmlspecialchars(strip_tags($this->invoice_payment));
            if ($this->invoice_payment == 1) {
                $this->invoice_page = 1;
                $this->invoice_payment_add = htmlspecialchars(strip_tags($this->invoice_payment_add));
            }
            else {
                $this->invoice_payment_add = 0;
            }

            $this->invoice_prorate = htmlspecialchars(strip_tags($this->invoice_prorate));
            ($this->invoice_prorate == 1) ? $this->invoice_page = 1 : $this->invoice_page = 0;

            // Plans Page Restrictions
            $this->plan_view = htmlspecialchars(strip_tags($this->plan_view));
            if ($this->plan_view == 1) {
                $this->plan_page = 1;
            }
            else {
                $this->plan_page = 0;
            }
            
            // Tickets Page Restrictions
            $this->ticket_page = htmlspecialchars(strip_tags($this->ticket_page));
            if ($this->ticket_page == 1) {
                $this->ticket_active = htmlspecialchars(strip_tags($this->ticket_active));
                ($this->ticket_active == 1) ? $this->ticket_pending = 1 : $this->ticket_pending = 0;
                $this->ticket_invalid = htmlspecialchars(strip_tags($this->ticket_invalid));
            }
            else {
                $this->ticket_active = 0;
                $this->ticket_pending = 0;
                $this->ticket_invalid = 0;
            }
            
            // Admins Page Restrictions
            $this->admin_view = htmlspecialchars(strip_tags($this->admin_view));

            $stmt->bindParam(':user_id', $this->user_id);

            $stmt->bindParam(':customer_page', $this->customer_page);
            $stmt->bindParam(':customer_list', $this->customer_list);
            $stmt->bindParam(':customer_add', $this->customer_add);
            $stmt->bindParam(':customer_import', $this->customer_import);

            $stmt->bindParam(':invoice_page', $this->invoice_page);
            $stmt->bindParam(':invoice_view', $this->invoice_view);
            $stmt->bindParam(':invoice_payment', $this->invoice_payment);
            $stmt->bindParam(':invoice_prorate', $this->invoice_prorate);
            $stmt->bindParam(':invoice_payment_add', $this->invoice_payment_add);

            $stmt->bindParam(':plan_page', $this->plan_page);
            $stmt->bindParam(':plan_view', $this->plan_view);

            $stmt->bindParam(':ticket_page', $this->ticket_page);
            $stmt->bindParam(':ticket_active', $this->ticket_active);
            $stmt->bindParam(':ticket_pending', $this->ticket_pending);
            $stmt->bindParam(':ticket_invalid', $this->ticket_invalid);

            $stmt->bindParam(':admin_page', $this->admin_page);
            $stmt->bindParam(':admin_view', $this->admin_view);

            try {
                $stmt->execute();
                return $stmt;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
            }
        }

        public function update_buttons_restriction () {
            $query = 'UPDATE restrict_buttons 
                SET invoice_edit = :invoice_edit,
                    payments_edit = :payments_edit,
                    payments_dlt = :payments_dlt,
                    prorate_edit = :prorate_edit,
                    prorate_dlt = :prorate_dlt,
                    plans_add = :plans_add,
                    plans_edit = :plans_edit,
                    active_claim = :active_claim,
                    active_invalid = :active_invalid,
                    pending_resolve = :pending_resolve,
                    pending_invalid = :pending_invalid,
                    invalid_reactivate = :invalid_reactivate,
                    invalid_delete = :invalid_delete,
                    custdata_edit = :custdata_edit,
                    admindata_edit = :admindata_edit,
                    admindata_reset = :admindata_reset,
                    admins_add = :admins_add,
                    tickets_add = :tickets_add
             WHERE user_id = :user_id';

            $stmt = $this->conn->prepare($query);
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));

            // Invoice Page Restrictions
            $this->payments_edit = htmlspecialchars(strip_tags($this->payments_edit));
            ($this->payments_edit == 1) ? $this->invoice_edit = 1 : $this->invoice_edit = 0;
            $this->payments_dlt = htmlspecialchars(strip_tags($this->payments_dlt));
            $this->prorate_edit = htmlspecialchars(strip_tags($this->prorate_edit));
            $this->prorate_dlt = htmlspecialchars(strip_tags($this->prorate_dlt));

            // Plans Page Restrictions
            $this->plans_add = htmlspecialchars(strip_tags($this->plans_add));
            $this->plans_edit = htmlspecialchars(strip_tags($this->plans_edit));
            
            // Tickets Page Restrictions
            $this->tickets_add = htmlspecialchars(strip_tags($this->tickets_add));
            $this->active_claim = htmlspecialchars(strip_tags($this->active_claim));
            if ($this->active_claim == 1) {
                $this->pending_resolve = 1;
                $this->pending_invalid = 1;
            }
            else {
                $this->pending_resolve = 0;
                $this->pending_invalid = 0;
            }
            
            $this->active_invalid = htmlspecialchars(strip_tags($this->active_invalid));
            if ($this->active_invalid == 1) {
                $this->invalid_reactivate = 1;
                $this->invalid_delete = 1;
            }
            else {
                $this->invalid_reactivate = 0;
                $this->invalid_delete = 0;
            }
            
            // Customer/Admin Details Page Restrictions
            $this->admins_add = htmlspecialchars(strip_tags($this->admins_add));
            $this->admindata_edit = htmlspecialchars(strip_tags($this->admindata_edit));
            ($this->admindata_edit == 1) ? $this->admindata_reset = 1 : $this->admindata_reset = 0;

            $this->custdata_edit = htmlspecialchars(strip_tags($this->custdata_edit));


            $stmt->bindParam(':user_id', $this->user_id);

            $stmt->bindParam(':invoice_edit', $this->invoice_edit);
            $stmt->bindParam(':payments_edit', $this->payments_edit);
            $stmt->bindParam(':payments_dlt', $this->payments_dlt);
            $stmt->bindParam(':prorate_edit', $this->prorate_edit);
            $stmt->bindParam(':prorate_dlt', $this->prorate_dlt);

            $stmt->bindParam(':plans_add', $this->plans_add);
            $stmt->bindParam(':plans_edit', $this->plans_edit);

            $stmt->bindParam(':active_claim', $this->active_claim);
            $stmt->bindParam(':active_invalid', $this->active_invalid);
            $stmt->bindParam(':pending_resolve', $this->pending_resolve);
            $stmt->bindParam(':pending_invalid', $this->pending_invalid);
            $stmt->bindParam(':invalid_reactivate', $this->invalid_reactivate);
            $stmt->bindParam(':invalid_delete', $this->invalid_delete);

            $stmt->bindParam(':custdata_edit', $this->custdata_edit);
            $stmt->bindParam(':admindata_edit', $this->admindata_edit);
            $stmt->bindParam(':admindata_reset', $this->admindata_reset);

            $stmt->bindParam(':admins_add', $this->admins_add);
            $stmt->bindParam(':tickets_add', $this->tickets_add);

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