<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Connection.php';

    $database = new Database();
    $db = $database->connect();

    $connection = new Connection ($db);

    $connection->connection_id = isset($_GET['connection_id']) ? $_GET['connection_id'] : die();

    $result = $connection->read_single();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $arr = array(
            'connection_id' => $connection_id,
            'connection_name' => $connection_name
        );

        print_r(json_encode($arr));
    }
    else
    {
        echo json_encode(
            array('message' => 'No Connection Found')
        );
    }