<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Views.php';

    $database = new Database();
    $db = $database->connect();

    $views = new Views ($db);

    $data = json_decode(file_get_contents("php://input"));

    $views->plan_name = $data->plan_name;
    $views->connection_name = $data->connection_name;
    $views->install_type_name = $data->install_type_name;
    $views->area_name = $data->area_name;
    $views->install_status = $data->install_status;

    $result = $views->getImportIDs();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        // extract($row);

        // $arr = array(
        //     'plan_id' => $plan_id,
        //     'connection_id' => $connection_id,
        //     'area_id' => $area_id,
        //     'install_type_id' => $install_type_id,
        //     'success' => true
        // );

        echo json_encode($row);
    }
    else
    {
        echo json_encode(
            array('success' => false)
        );
    }