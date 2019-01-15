<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/user.php';
include_once '../objects/token.php';
 
$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$token = new Token($db);
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if( !empty($data->username) && !empty($data->password)) {
 
    // set product property values
    $user->username = $data->username;
    $user->email = $data->username;
    $user->password = $data->password;

    $stmt = $user->login();
    $num = $stmt->rowCount();
    // create the product
    if($num > 0){

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $user_id = $row['id'];

        // update token
        $token->user_id = $user_id;
        $user_token = $token->updateToken();

        // set response code - 200 created
        http_response_code(200); 
        echo json_encode(array("message" => "User logged Successfully.", "token" => $user_token));
    } else{ 
        // set response code - 503 service unavailable
        http_response_code(503); 
        echo json_encode(array("message" => "Unable to login."));
    }
}else{
 
    // set response code - 400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Unable to Login. Data is incomplete."));
}
?>