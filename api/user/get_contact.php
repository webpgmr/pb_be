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
include_once '../objects/contact.php';
include_once '../objects/token.php';

// instantiate database and object
$database = new Database();
$db = $database->getConnection();

// getting token from header
$headers = apache_request_headers();
$current_token = $headers['Authorization'];

// get user information
$data = json_decode(file_get_contents("php://input"));

// initializing contact object
$contact = new Contact($db);
$token = new Token($db);

// set contact information
$contact->user_id = isset($data->user_id)? $data->user_id : 0;

//checking user exist already
$token->user_id = $data->user_id;
$user_token = $token->getUserToken();

if ($user_token === $current_token) {    
    $contact->user_id = $data->user_id;
    $smt = $contact->getUserContacts();
    $num = $smt->rowCount();
 
    // check if more than 0 record found
    if($num>0){
    
        // contact array
        $contacts_arr=array();
        $contacts_arr["result"]=array();
    
        // retrieve our table contents
        while ($row = $smt->fetch(PDO::FETCH_ASSOC)){
            extract($row);    
            $contacts=array(
                "id" => $id,
                "firstname" => $firstname,
                "lastname" => $lastname,
                "mobile" => $mobile,
                "landline" => $landline,
                "dob" => $dob,
                "sex" => $sex,
                "email" => $email,
                "street" => $street,
                "state" => $state,
                "country" => $country,
                "pincode" => $pincode                
            );
                array_push($contacts_arr["result"], $contacts);
        }
    
        // set response code - 200 OK
        http_response_code(200);    
        echo json_encode(array("data" => $contacts_arr, "status_code"=>"200"));
    } else {
        // set response code - 200 OK
        http_response_code(200);    
        echo json_encode(array("data" => "", "status_code"=>"200"));
    }     
} else {
    // set response code - 401 Unauthorised
    http_response_code(200);
    echo json_encode(array("message" => "Unauthorised Access", "status_code" => "401"));
}
?>
