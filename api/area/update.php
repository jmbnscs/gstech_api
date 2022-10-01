<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Area.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate plan object
$area = new Area($db);

// Get raw data
$data = json_decode(file_get_contents("php://input"));

// ID to Update
$area->area_id = $data->area_id;

$area->area_name = $data->area_name;

// Update Area
if($area->update()) {
    echo json_encode(
        array('message' => 'Area Updated')
);
} else {
    echo json_encode(
        array('message' => 'Area not updated')
    );
}
