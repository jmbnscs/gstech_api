<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Admin.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate admin object
    $admin = new Admin($db);

    // ID to Update
    $admin->admin_username = isset($_GET['admin_username']) ? $_GET['admin_username'] : die();

    // Get Post
    if( $admin->update_attempts()){
        echo json_encode(
            array('message' => 'Attempts Updated')
        );
    }
    else {
        echo json_encode(
            array('message' => 'Attempts Not Updated')
        );
    }