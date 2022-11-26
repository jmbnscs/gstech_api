<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/LogsDatabase.php';
    include_once '../../models/Logs.php';

    // Instantiate DB & Connect
    $database = new LogsDatabase();
    $db = $database->connect();

    $log = new Logs ($db);

    $log->admin_id = isset($_GET['admin_id']) ? $_GET['admin_id'] : die();

    // Account Read Query
    $result = $log->read_admin_log();

    // Get row count
    $num = $result->rowCount();

    // Check if any Accounts Exist
    if ($num > 0)
    {
        // Post Array
        $arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $data = array(
                'id' => $id,
                'admin_id' => $admin_id,
                'username' => $username,
                'activity' => $activity,
                'ip_address' => $ip_address,
                'user_agent' => $user_agent,
                'date_accessed' => $date_accessed
        );

            // Push to "data"
            array_push($arr, $data);
        }

        // Turn to JSON & Output
        echo json_encode($arr);
    }
    else
    {
        // No Accounts
        echo json_encode(
            array('message' => 'No Logs Found')
        );
    }