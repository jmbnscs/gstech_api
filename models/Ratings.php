<?php
    class Ratings 
    {
        private $conn;
        private $table = 'ratings';

        # Properties
        public $rating_base;
        public $delinquent_ratings;
        public $avg_rating;
        public $ratings_status_id;
        public $account_id;
        public $invoice_status;

        public $error;
        
        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Ratings
        public function create ()
        {
            // Clean Data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            // Create Query
            $query = 'INSERT INTO ' . 
                    $this->table . '
                SET
                    account_id = :account_id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind Data
            $stmt->bindParam(':account_id', $this->account_id);

            // Execute Query
            try {
                $stmt->execute();
                return true;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }


        # Get Ratings 
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
                account_id = :account_id';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':account_id', $this->account_id);

            // Execute Query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->account_id = $row['account_id'];
            $this->rating_base = $row['rating_base'];
            $this->delinquent_ratings = $row['delinquent_ratings'];
            $this->avg_rating = $row['avg_rating'];
            $this->ratings_status_id = $row['ratings_status_id'];
        }

        # Update Ratings
        public function update()
        {
            $query = 'SELECT rating_base, delinquent_ratings, ratings_status_id FROM ratings WHERE account_id = :account_id';
            $stmt = $this->conn->prepare($query);

            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $stmt->bindParam(':account_id', $this->account_id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);

            $new_rating_status = $ratings_status_id;
            $new_delinquent_ratings = $delinquent_ratings;
            $new_rating_base = ((int)$rating_base) + 1;

            if ($this->invoice_status == 3 && $this->invoice_status == 4) {
                $new_delinquent_ratings = ((int)$delinquent_ratings) + 1;
            }

            $new_average_rating = 100 - (($new_delinquent_ratings / $new_rating_base) * 100);

            if ($new_average_rating < 30) {
                $new_rating_status = 2;
            }

            $query = 'UPDATE ratings SET rating_base = :new_rating_base, delinquent_ratings = :new_delinquent_ratings, avg_rating = :new_average_rating, ratings_status_id = :new_rating_status WHERE account_id = :account_id';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':new_rating_base', $new_rating_base);
            $stmt->bindParam(':new_delinquent_ratings', $new_delinquent_ratings);
            $stmt->bindParam(':new_average_rating', $new_average_rating);
            $stmt->bindParam(':new_rating_status', $new_rating_status);
            $stmt->bindParam(':account_id', $this->account_id);

            try {
                $stmt->execute();
                return true;
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }
        }

        # Delete Rating
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

        private function isAccountExist()
        {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE account_id = :account_id';

            $stmt = $this->conn->prepare($query);

            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $stmt->bindParam(':account_id', $this->account_id);

            try {
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row) {
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