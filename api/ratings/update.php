<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Ratings.php';

    $database = new Database();
    $db = $database->connect();

    $rate = new Ratings($db); 

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to update
    $rate->account_id = $data->account_id;
    $invoice_status = $data->invoice_status;
    $rate->rating_base = $data->rating_base + 1;

    if ($invoice_status === 3 || $invoice_status === 4) 
    {
        $rate->delinquent_ratings = $data->delinquent_ratings + 1;
    }
    else
    {
        $rate->delinquent_ratings = $data->delinquent_ratings;
    }

    $rate->avg_rating = ($rate->delinquent_ratings / $rate->rating_base) * 100;

    ($rate->avg_rating >= 70) ? $rate->ratings_status_id = 1 : $rate->ratings_status_id = 2;

    // Update Rating
    if ($rate->update())
    {
        echo json_encode(
            array ('message' => 'Rating Updated')
        );
    }
    else
    {
        echo json_encode(
            array ('message' => 'Rating Not Updated')
        );
    }