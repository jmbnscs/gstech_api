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
            if ($stmt->execute())
            {
                return true;
            }
            else
            {
                // Print error if something goes wrong
                printf("Error: %s.\n", $stmt->error);

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

        # Update Ratings
        public function update()
        {
            // Create Query
            $query = 'UPDATE ' . 
            $this->table . '
            SET
            rating_base = :rating_base,
            delinquent_ratings = :delinquent_ratings,
            avg_rating = :avg_rating,
            ratings_status_id = :ratings_status_id
            WHERE 
            account_id = :account_id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->rating_base = htmlspecialchars(strip_tags($this->rating_base));
            $this->delinquent_ratings = htmlspecialchars(strip_tags($this->delinquent_ratings));
            $this->avg_rating = htmlspecialchars(strip_tags($this->avg_rating));
            $this->ratings_status_id = htmlspecialchars(strip_tags($this->ratings_status_id));
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            // Bind Data
            $stmt->bindParam(':rating_base', $this->rating_base);
            $stmt->bindParam(':delinquent_ratings', $this->delinquent_ratings);
            $stmt->bindParam(':avg_rating', $this->avg_rating);
            $stmt->bindParam(':ratings_status_id', $this->ratings_status_id);
            $stmt->bindParam(':account_id', $this->account_id);

            // Execute Query
            if ($stmt->execute())
            {
            return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        # Delete Rating
        public function delete()
        {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE account_id = :account_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            // Bind data
            $stmt->bindParam(':account_id', $this->account_id);

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
    }