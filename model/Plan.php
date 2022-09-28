<?php

class Plan {
    // Database variables
    private $conn;
    private $table = 'plan';

    // Table Columns required variables
    public $plan_id;
    public $plan_name;
    public $bandwidth;
    public $price;
    public $promo_id;
    public $plan_status_id;

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // Update
    public function update() {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                            SET plan_name = :plan_name, bandwidth = :bandwidth, price = :price, rate_per_minute = (SELECT plan_compute_rpm(:price)), created_at = current_timestamp(), promo_id = :promo_id, plan_status_id = :plan_status_id
                            WHERE plan_id = :plan_id';
  
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Clean data
        $this->plan_name = htmlspecialchars(strip_tags($this->plan_name));
        $this->bandwidth = htmlspecialchars(strip_tags($this->bandwidth));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->promo_id = htmlspecialchars(strip_tags($this->promo_id));
        $this->plan_status_id = htmlspecialchars(strip_tags($this->plan_status_id));
        $this->plan_id = htmlspecialchars(strip_tags($this->plan_id));
  
        // Bind data
        $stmt->bindParam(':plan_name', $this->plan_name);
        $stmt->bindParam(':bandwidth', $this->bandwidth);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':promo_id', $this->promo_id);
        $stmt->bindParam(':plan_status_id', $this->plan_status_id);
        $stmt->bindParam(':plan_id', $this->plan_id);
  
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

    // Delete Post
    public function delete() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE plan_id = :plan_id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->plan_id = htmlspecialchars(strip_tags($this->plan_id));

        // Bind data
        $stmt->bindParam(':plan_id', $this->plan_id);

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