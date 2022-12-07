<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Restriction.php';
    include_once '../../models/Pages.php';

    $database = new Database();
    $db = $database->connect();

    $restriction = new Restriction ($db);
    $pages = new Pages ($db);

    // $id = isset($_GET['user_id']) ? $_GET['user_id'] : die();

    $restriction->user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();

    $result = $restriction->get_pages_restriction();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $row = $result->fetch(PDO::FETCH_ASSOC);

        $arr = array();

        foreach ($row as $key => $value) {
            if ($value == 1) {
                $pages->navbar_id = strtr($key, '_', '-');
                $response = $pages->get_description();
                $desc = $response->fetch(PDO::FETCH_ASSOC);

                if ($desc['description'] !== "-" && $desc['description'] !== "") {
                    array_push($arr, $desc['description']);
                }
                // array_push($arr, strtr($key, '_', '-') . " => $value");
                // print strtr($key, '_', '-') . " => $value\n";
            }
        }

        // print $arr;
        // extract($row);

        // $data = array(
        //     'dashboard-page' => $dashboard_page,
        //     'customer-page' => $customer_page,
        //     'customer-list' => $customer_list,
        //     'customer-add' => $customer_add,
        //     'customer-import' => $customer_import,
        //     'invoice-page' => $invoice_page,
        //     'invoice-view' => $invoice_view,
        //     'invoice-payment' => $invoice_payment,
        //     'invoice-prorate' => $invoice_prorate,
        //     'invoice-payment-add' => $invoice_payment_add,
        //     'plan-page' => $plan_page,
        //     'plan-view' => $plan_view,
        //     'plan-add' => $plan_add,
        //     'ticket-page' => $ticket_page,
        //     'ticket-active' => $ticket_active,
        //     'ticket-pending' => $ticket_pending,
        //     'ticket-resolved' => $ticket_resolved,
        //     'ticket-invalid' => $ticket_invalid,
        //     'ticket-create' => $ticket_create,
        //     'admin-page' => $admin_page,
        //     'admin-view' => $admin_view,
        //     'admin-add' => $admin_add,
        //     'misc-page' => $misc_page,
        //     'profile-page' => $profile_page
        // );

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