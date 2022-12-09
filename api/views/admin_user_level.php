<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Views.php';

    $database = new Database();
    $db = $database->connect();

    $views = new Views ($db);

    $views->user_role = isset($_GET['user_role']) ? $_GET['user_role'] : die();

    $result = $views->admin_user_level();

    // Get row count
    $num = $result->rowCount();

    // Check if any posts
    if ($num > 0)
    {
        // Post Array
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            $data = array(
                // Admin Info
                'admin_id' => $admin_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'role' => $role,
                'admin_email' => $admin_email,
                'status' => $status
            );

            // Push to "data"
            array_push($arr, $data);
        }

        // Turn to JSON & Output
        echo json_encode($arr);
    }
    else
    {
        // No Categories
        echo json_encode(
            array('message' => 'No Accounts Found')
        );
    }
    