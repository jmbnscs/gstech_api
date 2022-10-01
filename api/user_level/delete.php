<?php 
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/UserLevel.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$user_level = new UserLevel($db);

// Get raw data
$data = json_decode(file_get_contents("php://input"));

// Set ID to Delete
$user_level->user_id = $data->user_id;

// Delete UserLevel
if($user_level->delete()) {
    echo json_encode(
    array('message' => 'User Level Deleted')
);
} else {
    echo json_encode(
    array('message' => 'User Level Not Deleted')
);
}

