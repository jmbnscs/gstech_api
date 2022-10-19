    <?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Inclusion.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate promo object
    $inclusion = new Inclusion($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // ID to Update
    $inclusion->inclusion_id = $data->inclusion_id;

    $inclusion->inclusion_name = $data->inclusion_name;

    // Update Inclusion
    if($inclusion->update()) {
        echo json_encode(
            array('message' => 'Inclusion Updated')
    );
    } else {
        echo json_encode(
            array('message' => 'Inclusion not updated')
        );
    }
