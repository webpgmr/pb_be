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
include_once '../objects/profile.php';
include_once '../objects/token.php';

// instantiate database and object
$database = new Database();
$db = $database->getConnection();

// get user information
$data = json_decode(file_get_contents("php://input"));

// initializing profile object
$profile = new Profile($db);
$token = new Token($db);

// set profile information
$profile->firstname = isset($data->firstname)? $data->firstname : '';
$profile->lastname = isset($data->lastname) ? $data->lastname: '';
$profile->dob = isset($data->dob) ? $data->dob : '';
$profile->mobile = isset($data->mobile) ? $data->mobile : '';
$profile->landline = isset($data->landline) ? $data->landline : '';
$profile->sex = isset($data->sex) ? $data->sex : '';
$profile->street = isset($data->street) ? $data->street : '';
$profile->staet = isset($data->state) ? $data->state : '';
$profile->country = isset($data->country) ? $data->country : '';
$profile->pincode = isset($data->pincode) ? $data->pincode : '';


//checking user exist already
$token->user_id = $data->user_id;
$user_token = $token->getUserToken();

if ($user_token === $data->token) {    
    $profile->user_id = $data->user_id;
    $smt = $profile->updateProfile();
    if ($smt) {
        // set response code - 200 OK
        http_response_code(200);
        // tell the user
        echo json_encode(array("message" => "Updated Profile Successfully.", "status_code" => "200"));
    } else {
        // set response code - 503 service unavialable
        http_response_code(503);
        echo json_encode(array("message" => "Unable to Update Profile ...Please try after some time", "status_code" => "503"));
    }    
} else {
    // set response code - 401 Unauthorised
    http_response_code(401);
    echo json_encode(array("message" => "Unauthorised Access", "status_code" => "401"));

}
?>
