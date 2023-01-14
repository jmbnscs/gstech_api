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

    $result = $restriction->get_buttons_restriction();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $data = array(
            'invoice-edit' => $invoice_edit,
            'payments-edit' => $payments_edit,
            'payments-dlt' => $payments_dlt,
            'prorate-edit' => $prorate_edit,
            'prorate-dlt' => $prorate_dlt,
            'plans-add' => $plans_add,
            'plans-edit' => $plans_edit,
            'tickets-add' => $tickets_add,
            'active-claim' => $active_claim,
            'active-invalid' => $active_invalid,
            'pending-resolve' => $pending_resolve,
            'pending-invalid' => $pending_invalid,
            'invalid-reactivate' => $invalid_reactivate,
            'invalid-delete' => $invalid_delete,
            'custdata-edit' => $custdata_edit,
            'admins-add' => $admins_add,
            'admindata-edit' => $admindata_edit,
            'admindata-reset' => $admindata_reset,
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