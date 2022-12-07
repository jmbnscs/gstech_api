<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Pages.php';

    $database = new Database();
    $db = $database->connect();

    $pages = new Pages ($db);

    $result = $pages->read_buttons();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $data = array(
                'btn_id' => $btn_id,
                'identifier' => $identifier,
                'page_dir' => $page_dir,
                'description' => $description
        );

            array_push($arr, $data);
        }

        echo json_encode($arr);
    }
    else
    {
        echo json_encode(
            array('message' => 'No Pages Found')
        );
    }