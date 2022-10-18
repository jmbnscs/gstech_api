<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Promo.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $promo = new Promo ($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $promo->plan_id = $data->plan_id;
    $promo->inclusion_id = $data->inclusion_id;

    // Create Promo
    if ($promo->create())
    {
        echo json_encode(
            array ('message' => 'Promo Created')
        );
    }
    else
    {
        echo json_encode(
            array ('message' => 'Promo Not Created')
        );
    }