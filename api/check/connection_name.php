<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Connection.php';

    $database = new Database();
    $db = $database->connect();

    $connection = new Connection ($db);

    $connection->connection_name = isset($_GET['connection_name']) ? $_GET['connection_name'] : die();

    if ($connection->isConnectionNameExist()) {
        echo json_encode(
            array(
                'error' => $connection->error,
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