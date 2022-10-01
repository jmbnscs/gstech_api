<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Prorate.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Prorate object
    $prorate = new Prorate($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to Delete
    $prorate->prorate_id = $data->prorate_id;

    // Delete Prorate
    if($prorate->delete()) {
        echo json_encode(
        array('message' => 'Prorate Deleted')
    );
    } else {
        echo json_encode(
        array('message' => 'Prorate Not Deleted')
    );
    }
