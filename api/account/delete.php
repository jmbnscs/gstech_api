<?php 
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Account.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate account object
$account = new Account($db);

// Get raw data
$data = json_decode(file_get_contents("php://input"));

// Set ID to Delete
$account->account_id = $data->account_id;

// Delete account
if($account->delete()) {
    echo json_encode(
        array ('success' => true)
    );
}
else
{
    echo json_encode(
        array (
            'success' => false,
            'error' => $account->error
        )
    );
}

