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
    $profile->getUserProfile();
    if($profile->firstname != '' ){
        // create array
        $profile_arr = array(
            "firstname" =>  $profile->firstname,
            "lastname" => $profile->lastname,
            "sex" => $product->sex,
            "dob" => $product->dob,
            "mobile" => $product->mobile,
            "landline" => $product->landline,
            "street" => $product->street,
            "state" => $product->state,
            "country" => $product->country,
            "pincode" => $product->pincode     
        );
     
        // set response code - 200 OK
        http_response_code(200);
     
        // make it json format
        echo json_encode(array("result" => $profile_arr, "status_code"=>"200", "message" => "User details"));
    }     
    else{
        // set response code - 404 Not found
        http_response_code(404);     
        echo json_encode(array("message" => "Profile does not exist.", "status_code" => "404"));
    }    
} else {
    // set response code - 401 Unauthorised
    http_response_code(401);
    echo json_encode(array("message" => "Unauthorised Access", "status_code" => "401"));

}
?>
