<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Admin.php';

    $database = new Database();
    $db = $database->connect();

    $admin = new Admin ($db);

    $admin->admin_id = isset($_GET['admin_id']) ? $_GET['admin_id'] : die();

    if ($admin->isAccountExist()) {
        echo json_encode(
            array(
                'error' => $admin->error,
                'exist' => true
            )
        );
    }
    else {
        echo json_encode(
            array(
                'exist' => false
            )
        );
    }