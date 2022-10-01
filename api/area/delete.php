<?php 
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Area.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$area = new Area($db);

// Get raw data
$data = json_decode(file_get_contents("php://input"));

// Set ID to Delete
$area->area_id = $data->area_id;

// Delete Area
if($area->delete()) {
    echo json_encode(
    array('message' => 'Area Deleted')
);
} else {
    echo json_encode(
    array('message' => 'Area Not Deleted')
);
}

