<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Area.php';

    $database = new Database();
    $db = $database->connect();

    $area = new Area ($db);

    $area->area_name = isset($_GET['area_name']) ? $_GET['area_name'] : die();

    if ($area->isAreaNameExist()) {
        echo json_encode(
            array(
                'error' => $area->error,
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