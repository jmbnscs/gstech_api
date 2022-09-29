<?php
    class Invoice 
    {
        private $conn;
        private $table = 'invoice';

        # Properties
        public $invoice_id;
        public $account_id;
        public $billing_period_start;
        public $billing_period_end;
        public $disconnection_date;
        public $previous_bill;
        public $previous_payment;
        public $balance;
        public $secured_cash;
        public $subscription_amount;
        public $prorated_charge;
        public $installation_charge;
        public $total_bill;
        public $invoice_status_id;
        public $payment_reference_id;
        public $amount_paid;
        public $payment_date;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create()
        {

        }

        # Get Invoice 
        public function read()
        {

        }

        # Update Invoice
        public function update()
        {

        }

        # Delete Invoice
        public function delete()
        {
            
        }
    }