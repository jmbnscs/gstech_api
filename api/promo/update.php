    <?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Promo.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate promo object
    $promo = new Promo($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // ID to Update
    $promo->promo_id = $data->promo_id;

    $promo->netflix = $data->netflix;
    $promo->fiber_switch = $data->fiber_switch;

    // Update Promo
    if($promo->update()) {
        echo json_encode(
            array('message' => 'Promo Updated')
    );
    } else {
        echo json_encode(
            array('message' => 'Promo not updated')
        );
    }
