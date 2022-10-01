<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Installation.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $installation = new Installation ($db);

    // GET ID
    $installation->account_id = isset($_GET['account_id']) ? $_GET['account_id'] : die();

    // Get Post
    $installation->read_single();

    // Create Array
    $cat_arr = array (
        'install_type_id' => $installation->install_type_id,
        'installation_total_charge' => $installation->installation_total_charge,
        'installation_balance' => $installation->installation_balance,
        'installment' => $installation->installment,
        'account_id' => $installation->account_id,
        'installation_status_id' => $installation->installation_status_id,
    );

    // Make JSON
    print_r(json_encode($cat_arr));