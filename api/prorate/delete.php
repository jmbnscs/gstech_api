<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Prorate.php';

    $database = new Database();
    $db = $database->connect();

    $prorate = new Prorate($db);

    $data = json_decode(file_get_contents("php://input"));

    $prorate->prorate_id = $data->prorate_id;

    if($prorate->delete()) {
        echo json_encode(
            array ('success' => true)
        );
    }
    else
    {
        echo json_encode(
            array (
                'success' => false,
                'error' => $payment->error
            )
        );
    }
