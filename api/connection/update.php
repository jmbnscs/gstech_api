<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Connection.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate plan object
$connection = new Connection($db);

// Get raw data
$data = json_decode(file_get_contents("php://input"));

// ID to Update
$connection->connection_id = $data->connection_id;

$connection->connection_name = $data->connection_name;

// Update Connection
if($connection->update()) {
    echo json_encode(
        array('message' => 'Connection Updated')
);
} else {
    echo json_encode(
        array('message' => 'Connection not updated')
    );
}
