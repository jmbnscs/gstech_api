<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Inclusion.php';

    $database = new Database();
    $db = $database->connect();

    $inclusion = new Inclusion ($db);

    $inclusion->inclusion_id = isset($_GET['inclusion_id']) ? $_GET['inclusion_id'] : die();

    $result = $inclusion->read_single();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $arr = array(
            'inclusion_id' => $inclusion_id,
            'inclusion_name' => $inclusion_name
        );

        print_r(json_encode($arr));
    }
    else
    {
        echo json_encode(
            array('message' => 'No Inclusion Found')
        );
    }