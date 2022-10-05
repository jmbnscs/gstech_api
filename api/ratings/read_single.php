<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Ratings.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $ratings = new Ratings ($db);

    // GET ID
    $ratings->account_id = isset($_GET['account_id']) ? $_GET['account_id'] : die();

    // Get Post
    $ratings->read_single();

    // Create Array
    $cat_arr = array (
        'account_id' => $ratings->account_id,
        'rating_base' => $ratings->rating_base,
        'delinquent_ratings' => $ratings->delinquent_ratings,
        'avg_rating' => $ratings->avg_rating,
        'ratings_status_id' => $ratings->ratings_status_id,
    );

    // Make JSON
    print_r(json_encode($cat_arr));