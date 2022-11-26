<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Area.php';

    $database = new Database();
    $db = $database->connect();

    $area = new Area ($db);

    $area->area_id = isset($_GET['area_id']) ? $_GET['area_id'] : die();

    $result = $area->read_single();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $arr = array(
            'area_id' => $area_id,
            'area_name' => $area_name
        );

        print_r(json_encode($arr));
    }
    else
    {
        echo json_encode(
            array('message' => 'No Area Found')
        );
    }