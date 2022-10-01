<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/UserLevel.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate plan object
$user_level = new UserLevel($db);

// Get raw data
$data = json_decode(file_get_contents("php://input"));

// ID to Update
$user_level->user_id = $data->user_id;

$user_level->user_role = $data->user_role;

// Update UserLevel
if($user_level->update()) {
    echo json_encode(
        array('message' => 'User Level Updated')
);
} else {
    echo json_encode(
        array('message' => 'User Level not updated')
    );
}
