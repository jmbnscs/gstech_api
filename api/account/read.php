<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Account.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Account object
    $account = new Account ($db);

    // Account Read Query
    $result = $account->read();

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
                'account_id' => $account_id,
                'start_date' => $start_date,
                'lockin_end_date' => $lockin_end_date,
                'billing_day' => $billing_day,
                'connection_id' => $connection_id,
                'plan_id' => $plan_id,
                'account_status_id' => $account_status_id,
                'area_id' => $area_id,
                'bill_count' => $bill_count,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
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
            array('message' => 'No Accounts Found')
        );
    }