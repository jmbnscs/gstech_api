<?php
    class Account 
    {
        private $conn;
        private $table = 'account';

        # Properties
        public $account_id;
        public $start_date;
        public $lockin_end_date;
        public $billing_day;
        public $plan_id;
        public $connection_id;
        public $account_status_id;
        public $area_id;
        public $bill_count;
        public $account_type;
        public $created_at;
        public $updated_at;

        public $error;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Account
        public function create()
        {
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $this->start_date = htmlspecialchars(strip_tags($this->start_date));
            $this->plan_id = htmlspecialchars(strip_tags($this->plan_id));
            $this->connection_id = htmlspecialchars(strip_tags($this->connection_id));
            $this->area_id = htmlspecialchars(strip_tags($this->area_id));

            $query = 'INSERT INTO ' . 
                    $this->table . '
                SET 
                    account_id = :account_id,
                    start_date = :start_date, 
                    lockin_end_date = :lockin_end_date, 
                    billing_day = :billing_day,
                    plan_id = :plan_id, 
                    connection_id = :connection_id, 
                    area_id = :area_id';

            $stmt = $this->conn->prepare($query);

            $this->setDates();

            $stmt->bindParam(':account_id', $this->account_id);
            $stmt->bindParam(':start_date', $this->start_date);
            $stmt->bindParam(':lockin_end_date', $this->lockin_end_date);
            $stmt->bindParam(':billing_day', $this->billing_day);
            $stmt->bindParam(':plan_id', $this->plan_id);
            $stmt->bindParam(':connection_id', $this->connection_id);
            $stmt->bindParam(':area_id', $this->area_id);

            try {
                $stmt->execute();
                return true;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }

        public function import()
        {
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $this->start_date = htmlspecialchars(strip_tags($this->start_date));
            $this->plan_id = htmlspecialchars(strip_tags($this->plan_id));
            $this->connection_id = htmlspecialchars(strip_tags($this->connection_id));
            $this->area_id = htmlspecialchars(strip_tags($this->area_id));
            $this->account_type = htmlspecialchars(strip_tags($this->account_type));
            $this->account_status_id = htmlspecialchars(strip_tags($this->account_status_id));

            $query = 'INSERT INTO ' . 
                    $this->table . '
                SET 
                    account_id = :account_id,
                    start_date = :start_date, 
                    lockin_end_date = :lockin_end_date, 
                    billing_day = :billing_day,
                    plan_id = :plan_id, 
                    connection_id = :connection_id, 
                    account_status_id = :account_status_id, 
                    account_type = :account_type, 
                    area_id = :area_id';

            $stmt = $this->conn->prepare($query);

            $this->setDates();

            $stmt->bindParam(':account_id', $this->account_id);
            $stmt->bindParam(':start_date', $this->start_date);
            $stmt->bindParam(':lockin_end_date', $this->lockin_end_date);
            $stmt->bindParam(':billing_day', $this->billing_day);
            $stmt->bindParam(':plan_id', $this->plan_id);
            $stmt->bindParam(':connection_id', $this->connection_id);
            $stmt->bindParam(':area_id', $this->area_id);
            $stmt->bindParam(':account_type', $this->account_type);
            $stmt->bindParam(':account_status_id', $this->account_status_id);

            try {
                $stmt->execute();
                return true;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }

        public function setDates()
        {
            $query = 'CALL account_set_dates (:start_date, @lockin_end_date, @billing_day)';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':start_date', $this->start_date);

            $stmt->execute();
            $stmt->closeCursor();

            $row = $this->conn->query("SELECT @lockin_end_date AS lockin_end_date, @billing_day AS billing_day")->fetch(PDO::FETCH_ASSOC);
            $this->lockin_end_date = $row['lockin_end_date'];
            $this->billing_day = $row['billing_day'];
        }

        # Get Account 
        public function read()
        {
            $query = 'SELECT 
            *
            FROM
            ' . $this->table . ' 
            ORDER BY created_at DESC';

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
                account_id = :account_id';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':account_id', $this->account_id);

            $stmt->execute();

            return $stmt;
        }

        # Update Account
        public function update() 
        {
            $query = 'UPDATE ' . $this->table . '
                    SET plan_id = :plan_id, 
                        connection_id = :connection_id, 
                        account_status_id = :account_status_id, 
                        area_id = :area_id
                    WHERE account_id = :account_id';
    
            $stmt = $this->conn->prepare($query);

            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $this->plan_id = htmlspecialchars(strip_tags($this->plan_id));
            $this->connection_id = htmlspecialchars(strip_tags($this->connection_id));
            $this->account_status_id = htmlspecialchars(strip_tags($this->account_status_id));
            $this->area_id = htmlspecialchars(strip_tags($this->area_id));

            $stmt->bindParam(':account_id', $this->account_id);
            $stmt->bindParam(':plan_id', $this->plan_id);
            $stmt->bindParam(':connection_id', $this->connection_id);
            $stmt->bindParam(':account_status_id', $this->account_status_id);
            $stmt->bindParam(':area_id', $this->area_id);
    
            try {
                if ($this->isAccountExist()) {
                    $stmt->execute();
                    return true;
                }
                else {
                    $this->error = 'Account ID does not exist.';
                    return false;
                }
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }

        # Delete Account
        public function delete() 
        {
            $query = 'DELETE FROM ' . $this->table . ' WHERE account_id = :account_id';

            $stmt = $this->conn->prepare($query);

            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            $stmt->bindParam(':account_id', $this->account_id);

            try {
                if ($this->isAccountExist()) {
                    $stmt->execute();
                    return true;
                }
                else {
                    $this->error = 'Account ID does not exist.';
                    return false;
                }
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }

        public function isAccountExist()
        {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE account_id = :account_id';

            $stmt = $this->conn->prepare($query);

            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $stmt->bindParam(':account_id', $this->account_id);

            try {
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row) {
                    $this->error = 'Account ID already exist.';
                    return true;
                }
                else {
                    return false;
                }
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }
    }