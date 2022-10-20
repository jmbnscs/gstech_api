<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Admin.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $admin = new Admin ($db);

    // GET ID
    $admin->admin_id = isset($_GET['admin_id']) ? $_GET['admin_id'] : die();

    // Get Post
    $admin->read_single();

    // Create Array
    $cat_arr = array (
        'admin_id' => $admin->admin_id,
        'admin_username' => $admin->admin_username,
        'admin_password' => $admin->admin_password,
        'admin_email' => $admin->admin_email,
        'mobile_number' => $admin->mobile_number,
        'first_name' => $admin->first_name,
        'middle_name' => $admin->middle_name,
        'last_name' => $admin->last_name,
        'birthdate' => $admin->birthdate,
        'address' => $admin->address,
        'employment_date' => $admin->employment_date,
        'login_attempts' => $admin->login_attempts,
        'created_at' => $admin->created_at,
        'admin_status_id' => $admin->admin_status_id,
        'user_level_id' => $admin->user_level_id,
        'hashed' => $admin->hashed,
        'message' => 'success',
    );

    // Make JSON
    print_r(json_encode($cat_arr));