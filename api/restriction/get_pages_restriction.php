<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Restriction.php';

    $database = new Database();
    $db = $database->connect();

    $restriction = new Restriction ($db);

    $restriction->user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();

    $result = $restriction->get_pages_restriction();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $data = array(
            'dashboard-page' => $dashboard_page,
            'customer-page' => $customer_page,
            'customer-list' => $customer_list,
            'customer-add' => $customer_add,
            'customer-import' => $customer_import,
            'invoice-page' => $invoice_page,
            'invoice-view' => $invoice_view,
            'invoice-payment' => $invoice_payment,
            'invoice-prorate' => $invoice_prorate,
            'invoice-payment-add' => $invoice_payment_add,
            'plan-page' => $plan_page,
            'plan-view' => $plan_view,
            'ticket-page' => $ticket_page,
            'ticket-active' => $ticket_active,
            'ticket-pending' => $ticket_pending,
            'ticket-invalid' => $ticket_invalid,
            'admin-page' => $admin_page,
            'admin-view' => $admin_view,
            'misc-page' => $misc_page,
            'profile-page' => $profile_page,
            'reports-page' => $reports_page,
        );

        echo json_encode($data);
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