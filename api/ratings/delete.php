<?php 
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Ratings.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$rate = new Ratings($db); 

// Get raw data
$data = json_decode(file_get_contents("php://input"));

// Set ID to Delete
$rate->account_id = $data->account_id;

// Delete Plan
if($rate->delete()) 
{
    echo json_encode(
        array('message' => 'Rating Deleted')
    );
} 
else 
{
    echo json_encode(
        array('message' => 'Rating Not Deleted')
    );
}

