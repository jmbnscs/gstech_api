<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Restriction.php';

    $database = new Database();
    $db = $database->connect();

    $restriction = new Restriction ($db);

    $restriction->user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();

    $result = $restriction->get_user_restriction();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $data = array(
                'user_id' => $user_id,
                'nav_id' => $nav_id
            );

            array_push($arr, $data);
        }

        echo json_encode($arr);
    }
    else
    {
        echo json_encode(
            array(
                'error' => $restriction->error,
                'success' => false
            )
        );
    }