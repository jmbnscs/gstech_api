<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Pages.php';

    $database = new Database();
    $db = $database->connect();

    $pages = new Pages ($db);

    $data = json_decode(file_get_contents("php://input"));

    $pages->user_id = $data->user_id;
    $pages->nav_id = $data->nav_id;

    $result = $pages->get_btn_restriction();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $data = array(
                'user_id' => $user_id,
                'page_button' => $page_button
            );

            array_push($arr, $data);
        }

        echo json_encode($arr);
    }
    else
    {
        echo json_encode(
            array(
                'error' => $pages->error,
                'success' => false
            )
        );
    }