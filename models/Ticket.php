<?php
    class Ticket 
    {
        private $conn;
        private $table = 'ticket';

        # Properties
        public $ticket_id;
        public $ticket_num;
        public $concern_id;
        public $concern_details;
        public $date_filed;
        public $date_resolved;
        public $resolution_details;
        public $ticket_status_id;
        public $account_id;
        public $admin_id;
        public $user_level;

        public $message;

        # Constructor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        # Create Post
        public function create()
        {
            // Create Query
            $query = 'INSERT INTO ' . 
                    $this->table . '
                SET
                    ticket_num = :ticket_num,
                    concern_id = :concern_id,
                    concern_details = :concern_details,
                    date_filed = :date_filed,
                    ticket_status_id = :ticket_status_id,
                    account_id = :account_id,
                    user_level = :user_level';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->ticket_num = htmlspecialchars(strip_tags($this->ticket_num));
            $this->concern_id = htmlspecialchars(strip_tags($this->concern_id));
            $this->concern_details = htmlspecialchars(strip_tags($this->concern_details));
            $this->date_filed = htmlspecialchars(strip_tags($this->date_filed));
            $this->ticket_status_id = htmlspecialchars(strip_tags($this->ticket_status_id));
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $this->user_level = htmlspecialchars(strip_tags($this->user_level));

            // Bind Data
            $stmt->bindParam(':ticket_num', $this->ticket_num);
            $stmt->bindParam(':concern_id', $this->concern_id);
            $stmt->bindParam(':concern_details', $this->concern_details);
            $stmt->bindParam(':date_filed', $this->date_filed);
            $stmt->bindParam(':ticket_status_id', $this->ticket_status_id);
            $stmt->bindParam(':account_id', $this->account_id);
            $stmt->bindParam(':user_level', $this->user_level);

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

        # Get Ticket 
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
                ticket_num = :ticket_num';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':ticket_num', $this->ticket_num);

            // Execute Query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->ticket_num = $row['ticket_num'];
            $this->concern_id = $row['concern_id'];
            $this->concern_details = $row['concern_details'];
            $this->date_filed = $row['date_filed'];
            $this->date_resolved = $row['date_resolved'];
            $this->resolution_details = $row['resolution_details'];
            $this->ticket_status_id = $row['ticket_status_id'];
            $this->account_id = $row['account_id'];
            $this->admin_id = $row['admin_id'];
            $this->user_level = $row['user_level'];
        }

        public function read_status()
        {
            // Create Query
            $query = 'SELECT 
                *
            FROM
             ' . $this->table . ' 
            WHERE
                ticket_status_id = :ticket_status_id';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);
            $this->ticket_status_id = htmlspecialchars(strip_tags($this->ticket_status_id));
            $stmt->bindParam(':ticket_status_id', $this->ticket_status_id);

            $stmt->execute();

            return $stmt;
        }

        public function read_single_account()
        {
            $query = 'SELECT 
                *
            FROM
             ' . $this->table . ' 
            WHERE 
                account_id = :account_id';
            
            $stmt = $this->conn->prepare($query);
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $stmt->bindParam(':account_id', $this->account_id);

            $stmt->execute();

            return $stmt;
        }

        # Update Ticket
        public function update() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET date_resolved = :date_resolved, 
                        resolution_details = :resolution_details, 
                        ticket_status_id = :ticket_status_id,
                        admin_id = :admin_id
                    WHERE ticket_num = :ticket_num';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->ticket_num = htmlspecialchars(strip_tags($this->ticket_num));
            $this->date_resolved = htmlspecialchars(strip_tags($this->date_resolved));
            $this->resolution_details = htmlspecialchars(strip_tags($this->resolution_details));
            $this->ticket_status_id = htmlspecialchars(strip_tags($this->ticket_status_id));
            $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));

            // Bind data
            $stmt->bindParam(':ticket_num', $this->ticket_num);
            $stmt->bindParam(':date_resolved', $this->date_resolved);
            $stmt->bindParam(':resolution_details', $this->resolution_details);
            $stmt->bindParam(':ticket_status_id', $this->ticket_status_id);
            $stmt->bindParam(':admin_id', $this->admin_id);

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

        # Delete Ticket
        public function delete()
        {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE ticket_num = :ticket_num';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->ticket_num = htmlspecialchars(strip_tags($this->ticket_num));

            // Bind data
            $stmt->bindParam(':ticket_num', $this->ticket_num);

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

        # Claim Ticket
        public function claim() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET ticket_status_id = :ticket_status_id,
                        admin_id = :admin_id
                    WHERE ticket_num = :ticket_num';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->ticket_num = htmlspecialchars(strip_tags($this->ticket_num));
            $this->ticket_status_id = htmlspecialchars(strip_tags($this->ticket_status_id));
            $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));

            // Bind data
            $stmt->bindParam(':ticket_num', $this->ticket_num);
            $stmt->bindParam(':ticket_status_id', $this->ticket_status_id);
            $stmt->bindParam(':admin_id', $this->admin_id);

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