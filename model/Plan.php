<?php
    class Plan 
    {
        // DB Stuff
        private $conn;
        private $table = 'plan';

        // Properties
        public $plan_name;
        public $bandwidth;
        public $price;
        public $rate_per_minute;
        public $promo_id;

        // Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create ()
        {
            // Clean Data
            $this->plan_name = htmlspecialchars(strip_tags($this->plan_name));
            $this->bandwidth = htmlspecialchars(strip_tags($this->bandwidth));
            $this->price = htmlspecialchars(strip_tags($this->price));
            $this->promo_id = htmlspecialchars(strip_tags($this->promo_id));
            // $this->compute_rpm();

            // Create Query
            $query = 'INSERT INTO ' . 
                    $this->table . '
                SET
                    plan_name = :plan_name,
                    bandwidth = :bandwidth,
                    price = :price,
                    rate_per_minute = plan_compute_rpm(:price),
                    promo_id = :promo_id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind Data
            $stmt->bindParam(':plan_name', $this->plan_name);
            $stmt->bindParam(':bandwidth', $this->bandwidth);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':promo_id', $this->promo_id);

            // Execute Query
            if ($stmt->execute())
            {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        # Get Plans
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
    }