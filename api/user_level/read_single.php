<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/UserLevel.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $user_level = new UserLevel ($db);

    // GET ID
    $user_level->user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();

    // Get Post
    $user_level->read_single();

    // Create Array
    $cat_arr = array (
        'user_id' => $user_level->user_id,
        'user_role' => $user_level->user_role,
        'message' => 'success',
    );

    // Make JSON
    print_r(json_encode($cat_arr));