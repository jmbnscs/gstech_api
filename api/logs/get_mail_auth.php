<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/LogsDatabase.php';
    include_once '../../models/Logs.php';

    $database = new LogsDatabase();
    $db = $database->connect();

    $log = new Logs ($db);

    $log->id = isset($_GET['id']) ? $_GET['id'] : die();

    $result = $log->get_mail_auth();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $data = array(
            'email' => $email,
            'password' => $password,
            'success' => true
        );

        echo json_encode($data);

    }
    else
    {
        echo json_encode(
            array(
                'success' => false
            )
        );
    }