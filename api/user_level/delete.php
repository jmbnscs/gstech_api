<?php 
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/UserLevel.php';
include_once '../../models/Restriction.php';

$database = new Database();
$db = $database->connect();

$user_level = new UserLevel($db);
$restriction = new Restriction($db);

$data = json_decode(file_get_contents("php://input"));

$user_level->user_id = $data->user_id;
$restriction->user_id = $data->user_id;

if($user_level->delete()) {
    if($restriction->delete_pages_restriction() && $restriction->delete_buttons_restriction()) {
        echo json_encode(
            array('success' => true)
        );
    }
} 
else {
    echo json_encode(
        array(
            'success' => false,
            'error' => $user_level->error
        )
    );
}

