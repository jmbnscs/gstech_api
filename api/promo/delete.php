    <?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Promo.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $promo = new Promo($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to Delete
    $promo->promo_id = $data->promo_id;

    // Delete Promo
    if($promo->delete()) {
        echo json_encode(
        array('message' => 'Promo Deleted')
    );
    } else {
        echo json_encode(
        array('message' => 'Promo Not Deleted')
    );
    }

