<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Inclusion.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $inclusion = new Inclusion ($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $inclusion->inclusion_name = $data->inclusion_name;

    // Create Inclusion
    if ($inclusion->create())
    {
        echo json_encode(
            array ('message' => 'Inclusion Created')
        );
    }
    else
    {
        echo json_encode(
            array ('message' => 'Inclusion Not Created')
        );
    }