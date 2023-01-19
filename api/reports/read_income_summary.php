<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Reports.php';

    $database = new Database();
    $db = $database->connect();

    $reports = new Reports ($db);

    $data = json_decode(file_get_contents("php://input"));

    $reports->date_to = $data->date_to;
    $reports->date_from = $data->date_from;

    $result = $reports->read_income_summary();

    $num = $result->rowCount();

    if ($num > 0)
    {
        $arr = array();

        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $date_from =new DateTime($reports->date_from); 
        $date_to = new DateTime($reports->date_to);     

        $Months = $date_to->diff($date_from); 
        $total_months = (($Months->y) * 12) + ($Months->m);

        if ($total_months == 0) {
            $total_expenses = $expenses;
        }
        else {
            $total_expenses = $expenses * $total_months;
        }

        $data = array(
            'total_expenses' => number_format((float)$total_expenses, 2, '.', ''),
            'sales' => $sales,
            'installation_sales' => ($installation_sales == null) ? '0.00' : $installation_sales,
            'prorate_loss' => ($prorate_loss == null) ? '0.00' : $prorate_loss
        );

        print_r(json_encode($data));
    }
    else
    {
        echo json_encode(
            array('message' => 'error')
        );
    }