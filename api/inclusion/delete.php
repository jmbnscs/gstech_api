    <?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Inclusion.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $inclusion = new Inclusion($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to Delete
    $inclusion->inclusion_id = $data->inclusion_id;

    // Delete Inclusion
    if($inclusion->delete()) {
        echo json_encode(
        array('message' => 'Inclusion Deleted')
    );
    } else {
        echo json_encode(
        array('message' => 'Inclusion Not Deleted')
    );
    }

