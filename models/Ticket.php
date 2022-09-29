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

        }

        # Get Ticket 
        public function read()
        {

        }

        # Update Ticket
        public function update()
        {

        }

        # Delete Ticket
        public function delete()
        {
            
        }
    }