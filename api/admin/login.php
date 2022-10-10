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
    $admin->admin_username = isset($_GET['admin_username']) ? $_GET['admin_username'] : die();

    // Get Post
    $admin->login();

    // Create Array
    // $cat_arr = array (
    //     'admin_id' => $admin->admin_id,
    //     'admin_username' => $admin->admin_username,
    //     'admin_password' => $admin->admin_password,
    //     'message' => 'success',
    // );

    // $cat_arr = array (
    //     'message' => $admin->message,
    // );

    // Create post
    if ($admin->message === 'success')
    {
        echo json_encode(
            array (
                'admin_id' => $admin->admin_id,
                'admin_username' => $admin->admin_username,
                'admin_password' => $admin->admin_password,
                'message' => 'success',
            )
        );
    }
    else
    {
        echo json_encode(
            array ('message' => 'failed')
        );
    }

    // Make JSON
    // print_r(json_encode($cat_arr));