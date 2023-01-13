<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Concerns.php';

    $database = new Database();
    $db = $database->connect();

    $concern = new Concerns ($db);

    $concern->concern_category = isset($_GET['concern_category']) ? $_GET['concern_category'] : die();

    if ($concern->isConcernCategoryExist()) {
        echo json_encode(
            array(
                'error' => $concern->error,
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