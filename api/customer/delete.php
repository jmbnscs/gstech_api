<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Customer.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate account object
    $customer = new Customer($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to Delete
    $customer->account_id = $data->account_id;

    // Delete account
    if($customer->delete()) {
        echo json_encode(
        array('message' => 'Customer Deleted')
    );
    } else {
        echo json_encode(
        array('message' => 'Customer Not Deleted')
    );
    }
