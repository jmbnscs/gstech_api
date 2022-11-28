<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/LogsDatabase.php';
    include_once '../../models/Logs.php';

    $database = new LogsDatabase();
    $db = $database->connect();

    $log = new Logs ($db);

    $log->admin_id = isset($_GET['admin_id']) ? $_GET['admin_id'] : die();

    $result = $log->read_admin_default();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $data = array(
            'admin_id' => $admin_id,
            'def_username' => $def_username,
            'def_password' => $def_password,
            'success' => true
        );

        echo json_encode($data);

    }
    else
    {
        echo json_encode(
            array(
                'success' => false,
                'error' => 'Admin ID does not exist.'
            )
        );
    }