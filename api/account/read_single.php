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

    // Get Post
    $account->read_single();

    // Create Array
    $cat_arr = array (
        'account_id' => $account->account_id,
        'start_date' => $account->start_date,
        'lockin_end_date' => $account->lockin_end_date,
        'billing_day' => $account->billing_day,
        'created_at' => $account->created_at,
        'plan_id' => $account->plan_id,
        'connection_id' => $account->connection_id,
        'account_status_id' => $account->account_status_id,
        'area_id' => $account->area_id,
        'bill_count' => $account->bill_count,
    );

    // Make JSON
    print_r(json_encode($cat_arr));