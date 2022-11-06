<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Account.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $account = new Account ($db);

    // GET ID
    $account->account_id = isset($_GET['account_id']) ? $_GET['account_id'] : die();

    // Account Read Query
    $result = $account->read_single();

    // Get row count
    $num = $result->rowCount();

    // Check if any Accounts Exist
    if ($num > 0)
    {
        $arr = array();

        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $data = array(
            'account_id' => $account_id,
            'start_date' => $start_date,
            'lockin_end_date' => $lockin_end_date,
            'billing_day' => $billing_day,
            'connection_id' => $connection_id,
            'account_status_id' => $account_status_id,
            'area_id' => $area_id,
            'bill_count' => $bill_count,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
            'message' => 'success'
        );

        print_r(json_encode($data));
    }
    else
    {
        echo json_encode(
            array('message' => 'error')
        );
    }