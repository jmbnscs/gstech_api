<?php 
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Connection.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$connection = new Connection($db);

// Get raw data
$data = json_decode(file_get_contents("php://input"));

// Set ID to Delete
$connection->connection_id = $data->connection_id;

// Delete Connection
if($connection->delete()) {
    echo json_encode(
    array('message' => 'Connection Deleted')
);
} else {
    echo json_encode(
    array('message' => 'Connection Not Deleted')
);
}

