<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Views.php';

    $database = new Database();
    $db = $database->connect();

    $views = new Views ($db);

    $views->account_id = isset($_GET['account_id']) ? $_GET['account_id'] : die();

    $result = $views->account_single();
    (checkData($result)) ?  $account_data = $result->fetch(PDO::FETCH_ASSOC) : $account_data = null;
    $result = $views->customer_single();
    (checkData($result)) ?  $customer_data = $result->fetch(PDO::FETCH_ASSOC) : $customer_data = null;
    $result = $views->install_single();
    (checkData($result)) ?  $install_data = $result->fetch(PDO::FETCH_ASSOC) : $install_data = null;
    $result = $views->rating_single();
    (checkData($result)) ?  $rating_data = $result->fetch(PDO::FETCH_ASSOC) : $rating_data = null;


    if ($account_data !== null && $customer_data !== null  && $install_data !== null  && $rating_data !== null)
    {
        extract($customer_data);
        extract($account_data);
        extract($install_data);
        extract($rating_data);
        $data = array(
            // Customer Info
            'gstech_id' => $gstech_id,
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name,
            'email' => $email,
            'mobile_number' => $mobile_number,
            'birthdate' => $birthdate,
            'billing_address' => $billing_address,
            // Account Info
            'account_id' => $account_id,
            'start_date' => $start_date,
            'lockin_end_date' => $lockin_end_date,
            'billing_day' => $billing_day,
            'plan_name' => $plan_name,
            'connection_type' => $connection_type,
            'area_name' => $area_name,
            'bill_count' => $bill_count,
            'account_status' => $account_status,
            // Installation Info
            'installation_type' => $installation_type,
            'installment' => $installment,
            'installation_total_charge' => $installation_total_charge,
            'installation_balance' => $installation_balance,
            'install_status' => $install_status,
            // Rating Info
            'rating_base' => $rating_base,
            'delinquent_ratings' => $delinquent_ratings,
            'avg_rating' => $avg_rating,
            'rating_status' => $rating_status
        );

        print_r(json_encode($data));
    }
    else
    {
        echo json_encode(
            array('message' => 'No Accounts Found')
        );
    }

    function checkData ($result) {
        $num = $result->rowCount();
        if ($num > 0) {
            return true;
        }
        else {
            return false;
        }
    }