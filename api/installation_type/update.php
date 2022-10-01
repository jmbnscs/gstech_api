<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/InstallationType.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate plan object
$installation_type = new InstallationType($db);

// Get raw data
$data = json_decode(file_get_contents("php://input"));

// ID to Update
$installation_type->install_type_id = $data->install_type_id;

$installation_type->install_type_name = $data->install_type_name;

// Update InstallationType
if($installation_type->update()) {
    echo json_encode(
        array('message' => 'Installation Type Updated')
);
} else {
    echo json_encode(
        array('message' => 'Installation Type not updated')
    );
}
