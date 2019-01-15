<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
include_once '../objects/profile.php';
include_once '../objects/token.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize user object
$user = new User($db);

// get user information
$data = json_decode(file_get_contents("php://input"));
// $data = json_decode('{
//     "username": "bijib10",
//     "password": "test123",
//     "email": "bijib10@test.com",
//     "firstname":"biji",
//     "lastname2": "b",
//     "dob":"2011-10-01"
//     }');
// set product property values
$user->username = isset($data->username) ? $data->username : '';
$user->password = isset($data->password) ? $data->password: '';
$user->email = isset($data->email) ? $data->email: '';

// initializing profile object
$profile = new Profile($db);
$token = new Token($db);

// set profile information
$profile->firstname = isset($data->firstname)? $data->firstname : '';
$profile->lastname = isset($data->lastname) ? $data->lastname: '';
$profile->dob = isset($data->dob) ? $data->dob : '';

//checking user exist already
$stmt = $user->validateUser();
$num = $stmt->rowCount();

if ($num > 0) {
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "User already exist."));
}else {
    // query user
    $last_id = $user->createUser();

    if ( $last_id > 0 ) {
        $profile->user_id = $last_id;
        $smt = $profile->createProfile();

        $token->user_id = $last_id;
        $tkn = $token->generateToken();
        if ($smt) {
            // on success
            // set response code - 200 OK
            http_response_code(200);
            // tell the user
            echo json_encode(array("message" => "User Created."));

        }else {
            // delete created User
            $user->id = $last_id;
            $user->delete();
            
            // set response code - 503 service unavailable
            http_response_code(503);
    
            // tell the user
            echo json_encode(array("message" => "Unable to create user."));
        }
    }
}

