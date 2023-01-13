<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Inclusion.php';

    $database = new Database();
    $db = $database->connect();

    $inclusion = new Inclusion ($db);

    $inclusion->inclusion_name = isset($_GET['inclusion_name']) ? $_GET['inclusion_name'] : die();

    if ($inclusion->isInclusionNameExist()) {
        echo json_encode(
            array(
                'error' => $inclusion->error,
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