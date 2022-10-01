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
                    ticket_num = ticket_gen_ticket_num(),
                    concern_id = :concern_id,
                    concern_details = :concern_details,
                    date_filed = :date_filed,
                    ticket_status_id = :ticket_status_id,
                    account_id = :account_id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->concern_id = htmlspecialchars(strip_tags($this->concern_id));
            $this->concern_details = htmlspecialchars(strip_tags($this->concern_details));
            $this->date_filed = htmlspecialchars(strip_tags($this->date_filed));
            $this->ticket_status_id = htmlspecialchars(strip_tags($this->ticket_status_id));
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));

            // Bind Data
            $stmt->bindParam(':concern_id', $this->concern_id);
            $stmt->bindParam(':concern_details', $this->concern_details);
            $stmt->bindParam(':date_filed', $this->date_filed);
            $stmt->bindParam(':ticket_status_id', $this->ticket_status_id);
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
        }

        # Update Ticket
        public function update() 
        {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                    SET ticket_num = :ticket_num,
                        concern_id = :concern_id, 
                        concern_details = :concern_details, 
                        date_filed = :date_filed, 
                        date_resolved = :date_resolved,
                        resolution_details = :resolution_details, 
                        ticket_status_id = :ticket_status_id,
                        account_id = :account_id, 
                        admin_id = :admin_id
                    WHERE ticket_id = :ticket_id';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->ticket_id = htmlspecialchars(strip_tags($this->ticket_id));
            $this->ticket_num = htmlspecialchars(strip_tags($this->ticket_num));
            $this->concern_id = htmlspecialchars(strip_tags($this->concern_id));
            $this->concern_details = htmlspecialchars(strip_tags($this->concern_details));
            $this->date_filed = htmlspecialchars(strip_tags($this->date_filed));
            $this->date_resolved = htmlspecialchars(strip_tags($this->date_resolved));
            $this->resolution_details = htmlspecialchars(strip_tags($this->resolution_details));
            $this->ticket_status_id = htmlspecialchars(strip_tags($this->ticket_status_id));
            $this->account_id = htmlspecialchars(strip_tags($this->account_id));
            $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));
    
            // Bind data
            $stmt->bindParam(':ticket_id', $this->ticket_id);
            $stmt->bindParam(':ticket_num', $this->ticket_num);
            $stmt->bindParam(':concern_id', $this->concern_id);
            $stmt->bindParam(':concern_details', $this->concern_details);
            $stmt->bindParam(':date_filed', $this->date_filed);
            $stmt->bindParam(':date_resolved', $this->date_resolved);
            $stmt->bindParam(':resolution_details', $this->resolution_details);
            $stmt->bindParam(':ticket_status_id', $this->ticket_status_id);
            $stmt->bindParam(':account_id', $this->account_id);
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
            $query = 'DELETE FROM ' . $this->table . ' WHERE ticket_id = :ticket_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->ticket_id = htmlspecialchars(strip_tags($this->ticket_id));

            // Bind data
            $stmt->bindParam(':ticket_id', $this->ticket_id);

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