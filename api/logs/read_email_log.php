<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/LogsDatabase.php';
    include_once '../../models/Logs.php';

    // Instantiate DB & Connect
    $database = new LogsDatabase();
    $db = $database->connect();

    $log = new Logs ($db);

    // Account Read Query
    $result = $log->read_email_log();

    // Get row count
    $num = $result->rowCount();

    // Check if any Accounts Exist
    if ($num > 0)
    {
        // Post Array
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $data = array(
                'id' => $id,
                'account_id' => $account_id,
                'invoice_id' => $invoice_id,
                'email_sent' => $email_sent,
                'status_id' => $status_id,
                'date_accessed' => $date_accessed
        );

            // Push to "data"
            array_push($arr, $data);
        }

        // Turn to JSON & Output
        echo json_encode($arr);
    }
    else
    {
        // No Accounts
        echo json_encode(
            array('message' => 'No Logs Found')
        );
    }