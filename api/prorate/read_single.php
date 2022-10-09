<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Prorate.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $prorate = new Prorate ($db);

    // GET ID
    $prorate->prorate_id = isset($_GET['prorate_id']) ? $_GET['prorate_id'] : die();

    // Get Post
    $prorate->read_single();

    // Create Array
    $cat_arr = array (
        'prorate_id' => $prorate->prorate_id,
        'duration' => $prorate->duration,
        'rate_per_minute' => $prorate->rate_per_minute,
        'prorate_charge' => $prorate->prorate_charge,
        'account_id' => $prorate->account_id,
        'invoice_id' => $prorate->invoice_id,
        'prorate_status_id' => $prorate->prorate_status_id,
    );

    // Make JSON
    print_r(json_encode($cat_arr));