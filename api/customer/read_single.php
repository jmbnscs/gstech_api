<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Customer.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $customer = new Customer ($db);

    // GET ID
    $customer->account_id = isset($_GET['account_id']) ? $_GET['account_id'] : die();

    // Get Post
    $customer->read_single();

    // Create Array
    $cat_arr = array (
        'account_id' => $customer->account_id,
        'first_name' => $customer->first_name,
        'middle_name' => $customer->middle_name,
        'last_name' => $customer->last_name,
        'billing_address' => $customer->billing_address,
        'mobile_number' => $customer->mobile_number,
        'email' => $customer->email,
        'birthdate' => $customer->birthdate,
        'gstech_id' => $customer->gstech_id,
        'customer_username' => $customer->customer_username,
        'customer_password' => $customer->customer_password,
        'user_level_id' => $customer->user_level_id,
    );

    // Make JSON
    print_r(json_encode($cat_arr));