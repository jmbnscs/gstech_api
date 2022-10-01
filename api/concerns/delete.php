    <?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Concerns.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $concerns = new Concerns($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to Delete
    $concerns->concern_id = $data->concern_id;

    // Delete Concerns
    if($concerns->delete()) {
        echo json_encode(
        array('message' => 'Concerns Deleted')
    );
    } else {
        echo json_encode(
        array('message' => 'Concerns Not Deleted')
    );
    }

