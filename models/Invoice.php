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
        public $invoice_reference_id;
        public $payment_reference_id;
        public $amount_paid;
        public $running_balance;
        public $payment_date;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create ()
        {
            // Clean Data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            $this->setBillingPeriodStart();
            $this->setEndDates();
            $this->setPreviousInfo();
            $this->setSubAmtAndInstallCharge();
            $this->setProrateCharge();
            $this->computeTotalBill(); // sets invoice status
            $this->setInvoiceID();

            // Create Query
            $query = 'INSERT INTO ' . 
                    $this->table . '
                SET
                    invoice_id = :invoice_id,
                    account_id = :account_id,
                    billing_period_start = :billing_period_start,
                    billing_period_end = :billing_period_end,
                    disconnection_date = :disconnection_date,
                    previous_bill = :previous_bill,
                    previous_payment = :previous_payment,
                    balance = :balance,
                    secured_cash = :secured_cash,
                    subscription_amount = :subscription_amount,
                    prorated_charge = :prorated_charge,
                    installation_charge = :installation_charge,
                    total_bill = :total_bill,
                    invoice_status_id = :invoice_status_id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind Data
            $stmt->bindParam(':invoice_id', $this->invoice_id);
            $stmt->bindParam(':account_id', $this->account_id);
            $stmt->bindParam(':billing_period_start', $this->billing_period_start);
            $stmt->bindParam(':billing_period_end', $this->billing_period_end);
            $stmt->bindParam(':disconnection_date', $this->disconnection_date);
            $stmt->bindParam(':previous_bill', $this->previous_bill);
            $stmt->bindParam(':previous_payment', $this->previous_payment);
            $stmt->bindParam(':balance', $this->balance);
            $stmt->bindParam(':secured_cash', $this->secured_cash);
            $stmt->bindParam(':subscription_amount', $this->subscription_amount);
            $stmt->bindParam(':prorated_charge', $this->prorated_charge);
            $stmt->bindParam(':installation_charge', $this->installation_charge);
            $stmt->bindParam(':total_bill', $this->total_bill);
            $stmt->bindParam(':invoice_status_id', $this->invoice_status_id);
            

            // Execute Query
            if ($stmt->execute())
            {
                $this->addBillCount();
                $this->updateProrateStatus();
                $this->setRunningBalance();
                $this->updateInstallment();
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        # Get Invoice 
        public function read()
        {
            // Create Query
            $query = 'SELECT 
                *
            FROM
             ' . $this->table;
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function read_single () 
        {
            $query = 'SELECT
                * FROM ' . 
            $this->table . ' 
            WHERE
                invoice_id = :invoice_id';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':invoice_id', $this->invoice_id);

            // Execute Query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->invoice_id = $row['invoice_id'];
            $this->account_id = $row['account_id'];
            $this->billing_period_start = $row['billing_period_start'];
            $this->billing_period_end = $row['billing_period_end'];
            $this->disconnection_date = $row['disconnection_date'];
            $this->previous_bill = $row['previous_bill'];
            $this->previous_payment = $row['previous_payment'];
            $this->balance = $row['balance'];
            $this->secured_cash = $row['secured_cash'];
            $this->subscription_amount = $row['subscription_amount'];
            $this->prorated_charge = $row['prorated_charge'];
            $this->installation_charge = $row['installation_charge'];
            $this->total_bill = $row['total_bill'];
            $this->invoice_status_id = $row['invoice_status_id'];
            $this->invoice_reference_id = $row['invoice_reference_id'];
            $this->payment_reference_id = $row['payment_reference_id'];
            $this->amount_paid = $row['amount_paid'];
            $this->running_balance = $row['running_balance'];
            $this->payment_date = $row['payment_date'];
        }

        public function read_single_account()
        {
            // Create Query
            $query = 'SELECT
                * FROM ' . 
            $this->table . ' 
            WHERE
                account_id = :account_id';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':account_id', $this->account_id);

            $stmt->execute();

            return $stmt;
        }

        public function read_by_status()
        {
            // Create Query
            $query = 'SELECT 
                *
            FROM
             ' . $this->table . ' 
            WHERE invoice_status_id = :invoice_status_id';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->invoice_status_id = htmlspecialchars(strip_tags($this->invoice_status_id));

            // Bind Data
            $stmt->bindParam(':invoice_status_id', $this->invoice_status_id);

            $stmt->execute();

            return $stmt;
        }

        public function read_latest()
        {
            try {
                $this->getLatestInvoice();
                $this->read_single();
                return true;
            } catch (Exception $e) {
                return false;
            }
        }

        # Update Invoice
        public function update() 
        {
           // Clean data
           $this->account_id = htmlspecialchars(strip_tags($this->account_id));
           $this->payment_reference_id = htmlspecialchars(strip_tags($this->payment_reference_id));
           $this->amount_paid = htmlspecialchars(strip_tags($this->amount_paid));
           $this->payment_date = htmlspecialchars(strip_tags($this->payment_date));

           $query = 'CALL invoice_set_payment (:account_id, :amount_paid, :payment_reference_id, :payment_date)';

           // Prepare statement
           $stmt = $this->conn->prepare($query);

           // Bind data
           $stmt->bindParam(':account_id', $this->account_id);
           $stmt->bindParam(':payment_reference_id', $this->payment_reference_id);
           $stmt->bindParam(':amount_paid', $this->amount_paid);
           $stmt->bindParam(':payment_date', $this->payment_date);

           // Execute query
           if($stmt->execute()) {
               $this->updateInstallationBalance();
               $this->getLatestInvoice();
               return true;
           }
           else {
               // Print error
               printf("Error: %s.\n", $stmt->error);
   
               return false;
           }
        }

        # for overdue / for disconnection, can be changed to automatic function
        public function update_status() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET invoice_status_id = :invoice_status_id
                    WHERE invoice_id = :invoice_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->invoice_id = htmlspecialchars(strip_tags($this->invoice_id));
            $this->invoice_status_id = htmlspecialchars(strip_tags($this->invoice_status_id));
            
                // Bind data
            $stmt->bindParam(':invoice_id', $this->invoice_id);
            $stmt->bindParam(':invoice_status_id', $this->invoice_status_id);
    
            // Execute query
            if($stmt->execute()) {
                return true;
            }
            else {
                // Print error
                printf("Error: %s.\n", $stmt->error);
    
                return false;
            }
        }

        # Delete Invoice
        public function delete() 
        {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE invoice_id = :invoice_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->invoice_id = htmlspecialchars(strip_tags($this->invoice_id));

            // Bind data
            $stmt->bindParam(':invoice_id', $this->invoice_id);

            // Execute query
            if($stmt->execute()) {
                return true;
            }
            else {
                // Print error
                printf("Error: %s.\n", $stmt->error);

                return false;
            }
        }

        private function setBillingPeriodStart()
        {
            // Create query
            $query = 'CALL invoice_set_billing_period_start (:account_id, @temp_start)';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            // Bind data
            $stmt->bindParam(':account_id', $this->account_id);

            // Execute query
            $stmt->execute();

            $stmt->closeCursor();

            $row = $this->conn->query("SELECT @temp_start AS temp_start")->fetch(PDO::FETCH_ASSOC);

            $this->billing_period_start = $row['temp_start'];
        }

        private function setEndDates()
        {
            // Create query
            $query = 'CALL invoice_set_end_dates (:account_id, @billing_period_end, @disconnection_date)';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            // Bind data
            $stmt->bindParam(':account_id', $this->account_id);

            // Execute query
            $stmt->execute();

            $stmt->closeCursor();

            $row = $this->conn->query("SELECT @billing_period_end AS billing_period_end, @disconnection_date AS disconnection_date")->fetch(PDO::FETCH_ASSOC);

            $this->billing_period_end = $row['billing_period_end'];
            $this->disconnection_date = $row['disconnection_date'];
        }

        private function setPreviousInfo()
        {
            // Create query
            $query = 'CALL invoice_get_prev_info (:account_id, @previous_bill, @previous_payment, @balance, @secured_cash)';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            // Bind data
            $stmt->bindParam(':account_id', $this->account_id);

            // Execute query
            $stmt->execute();

            $stmt->closeCursor();

            $row = $this->conn->query("SELECT @previous_bill AS previous_bill, @previous_payment AS previous_payment, @balance AS balance, @secured_cash AS secured_cash")->fetch(PDO::FETCH_ASSOC);

            $this->previous_bill = $row['previous_bill'];
            $this->previous_payment = $row['previous_payment'];
            $this->balance = $row['balance'];
            $this->secured_cash = $row['secured_cash'];
        }

        private function setSubAmtAndInstallCharge()
        {
            // Create query
            $query = 'SELECT * FROM account_view_charges WHERE account_id = :account_id;';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':account_id', $this->account_id);

            // Execute Query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->subscription_amount = $row['price'];
            $bill_count = $this->fetchBillCount();

            if ($row['install_type_id'] === 2)
            {
                ($bill_count < 6) ? $this->installation_charge = 200 : $this->installation_charge = 0;
            }
            else
            {
                $this->installation_charge = 0;
            }
        }

        private function fetchBillCount()
        {
            // Create query
            $query = 'CALL account_get_bill_count (:account_id, @counter)';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            // Bind data
            $stmt->bindParam(':account_id', $this->account_id);

            // Execute query
            $stmt->execute();

            $stmt->closeCursor();

            $row = $this->conn->query("SELECT @counter AS bill_count")->fetch(PDO::FETCH_ASSOC);

            return $row['bill_count'];
        }

        private function setProrateCharge()
        {
            // Create query
            $query = 'CALL invoice_get_prorate (:account_id, @prorated_charge)';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            // Bind data
            $stmt->bindParam(':account_id', $this->account_id);

            // Execute query
            $stmt->execute();

            $stmt->closeCursor();

            $row = $this->conn->query("SELECT @prorated_charge AS prorated_charge")->fetch(PDO::FETCH_ASSOC);

            $this->prorated_charge = $row['prorated_charge'];
        }

        private function computeTotalBill()
        {
            // Create query
            $query = 'CALL invoice_compute_total_bill (:balance, :secured_cash, :subscription_amount, :prorated_charge, :installation_charge, @total_bill)';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->balance = htmlspecialchars(strip_tags($this->balance));
            $this->secured_cash = htmlspecialchars(strip_tags($this->secured_cash));
            $this->subscription_amount = htmlspecialchars(strip_tags($this->subscription_amount));
            $this->prorated_charge = htmlspecialchars(strip_tags($this->prorated_charge));
            $this->installation_charge = htmlspecialchars(strip_tags($this->installation_charge));

            // Bind data
            $stmt->bindParam(':balance', $this->balance);
            $stmt->bindParam(':secured_cash', $this->secured_cash);
            $stmt->bindParam(':subscription_amount', $this->subscription_amount);
            $stmt->bindParam(':prorated_charge', $this->prorated_charge);
            $stmt->bindParam(':installation_charge', $this->installation_charge);

            // Execute query
            $stmt->execute();

            $stmt->closeCursor();

            $row = $this->conn->query("SELECT @total_bill AS total_bill")->fetch(PDO::FETCH_ASSOC);

            $this->total_bill = $row['total_bill'];

            ($this->total_bill <= 0 ) ? $this->invoice_status_id = 1 : $this->invoice_status_id = 2;
        }

        private function setInvoiceID()
        {
            // Create query
            $query = 'CALL invoice_gen_id (:billing_period_start, :account_id, @invoice_id)';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->billing_period_start = htmlspecialchars(strip_tags($this->billing_period_start));
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            // Bind data
            $stmt->bindParam(':billing_period_start', $this->billing_period_start);
            $stmt->bindParam(':account_id', $this->account_id);

            // Execute query
            $stmt->execute();

            $stmt->closeCursor();

            $row = $this->conn->query("SELECT @invoice_id AS invoice_id")->fetch(PDO::FETCH_ASSOC);

            $this->invoice_id = $row['invoice_id'];
        }

        private function setRunningBalance()
        {
            // Create query
            $query = 'CALL invoice_set_running_bal (:account_id, :invoice_id)';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $this->invoice_id = htmlspecialchars(strip_tags($this->invoice_id));

            // Bind data
            $stmt->bindParam(':account_id', $this->account_id);
            $stmt->bindParam(':invoice_id', $this->invoice_id);

            // Execute query
            $stmt->execute();

            $stmt->closeCursor();
        }

        private function addBillCount()
        {
            // Create query
            $query = 'CALL account_add_bill_count (:account_id)';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            // Bind data
            $stmt->bindParam(':account_id', $this->account_id);

            // Execute query
            $stmt->execute();

            $stmt->closeCursor();
        }

        private function updateProrateStatus()
        {
            // Get Uncharged ID
            $prorate_id = 1;

            while ($prorate_id !== null)
            {
                $prorate_id = $this->fetchUnchargedProrate();

                if ($prorate_id === null) {
                    break;
                }

                // Create query
                $query = 'CALL prorate_update_status (:invoice_id, :prorate_id, :account_id)';
                // Not yet edited

                // Prepare statement
                $stmt = $this->conn->prepare($query);

                // Clean data
                $this->invoice_id = htmlspecialchars(strip_tags($this->invoice_id));
                $prorate_id = htmlspecialchars(strip_tags($prorate_id));
                $this->account_id = htmlspecialchars(strip_tags($this->account_id));

                // Bind data
                $stmt->bindParam(':invoice_id', $this->invoice_id);
                $stmt->bindParam(':prorate_id', $prorate_id);
                $stmt->bindParam(':account_id', $this->account_id);

                // Execute query
                $stmt->execute();

                $stmt->closeCursor();
            }
        }

        private function fetchUnchargedProrate()
        {
            // Create query
            $query = 'CALL prorate_fetch_uncharged (:account_id, @pro_id)';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            // Bind data
            $stmt->bindParam(':account_id', $this->account_id);

            // Execute query
            $stmt->execute();

            $stmt->closeCursor();

            $row = $this->conn->query("SELECT @pro_id AS pro_id")->fetch(PDO::FETCH_ASSOC);

            return $row['pro_id'];
        }

        // Not sure if you have this already but execute this when update payment is successfully executed
        private function updateInstallment()
        {
            // Create query
            $query = 'CALL install_update_installment (:account_id)';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            // Bind data
            $stmt->bindParam(':account_id', $this->account_id);

            // Execute query
            $stmt->execute();

            $stmt->closeCursor();
        }

        private function updateInstallationBalance()
        {
            // Create query
            $query = 'CALL install_update_balance (:account_id, :amount_paid)';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $this->amount_paid = htmlspecialchars(strip_tags($this->amount_paid));

            // Bind data
            $stmt->bindParam(':account_id', $this->account_id);
            $stmt->bindParam(':amount_paid', $this->amount_paid);

            // Execute query
            $stmt->execute();

            $stmt->closeCursor();
        }

        private function getLatestInvoice()
        {
            // Create query
            $query = 'SET @invoice_id = (SELECT invoice_get_latest(:account_id));';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            // Bind data
            $stmt->bindParam(':account_id', $this->account_id);

            // Execute query
            $stmt->execute();

            $stmt->closeCursor();

            $row = $this->conn->query("SELECT @invoice_id AS invoice_id")->fetch(PDO::FETCH_ASSOC);

            $this->invoice_id = $row['invoice_id'];
        }
    }