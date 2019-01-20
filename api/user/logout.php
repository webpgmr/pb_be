<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate object
include_once '../objects/user.php';
include_once '../objects/token.php';
 
$database = new Database();
$db = $database->getConnection();

// initialize object
$token = new Token($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if( !empty($data->user_id) ) { 
    // set property values
    $token->user_id = $data->user_id;
    $stmt = $token->expireToken();
    
    if($stmt){
        // set response code - 200 ok
        http_response_code(200); 
        echo json_encode(array("message" => "User Loggedout Successfully.", "status_code" => "200"));        
    } else{ 
        // set response code - Bad Request
        http_response_code(200);
        echo json_encode(array("message" => "Unable to Logout.", "status_code" => "400"));
    }
}else{ 
    // set response code - 400 bad request
    http_response_code(200);
    echo json_encode(array("message" => "Unable to Logout. Data is incomplete."));
}

?>
