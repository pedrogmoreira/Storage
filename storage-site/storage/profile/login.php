<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/profile.php';
 
// instantiate database and profile object
$database = new Database();
$db_conn = $database->getConnection();
 
// initialize object
$profile = new Profile($db_conn);

if (isset($_GET['email'])) 
 $profile->email = $_GET['email'];
 else {
     echo json_encode(
        array("error" => "No email requested.")
    );
    die();
 }
 if (isset($_GET['password'])) 
 $profile->password = $_GET['password'];
 else {
     echo json_encode(
        array("error" => "No password requested.")
    );
    die();
 }
 
// query profiles
$profile->login();

// check if more than 0 record found
if($profile->user){
    
    $data = array(
        "email" =>  $profile->email,
        "user" => array(
            "id_user" => $profile->user->id,
            "cpf" => $profile->user->cpf,
            "first_name" => $profile->user->first_name,
            "last_name" => $profile->user->last_name,
            "birth_date" => $profile->user->birth_date,
            "address" => array(
                    "id_address" => $profile->user->address->id,
                    "cep" => $profile->user->address->cep,
                    "public_place" => $profile->user->address->public_place,
                    "complement" => $profile->user->address->complement,
                    "neighborhood" => $profile->user->address->neighborhood,
                    "city" => $profile->user->address->city,
                    "state" => $profile->user->address->state,
                    "state_uf" => $profile->user->address->state_uf,
                    "country" => $profile->user->address->country,
                    "number" => $profile->user->address->number
                ),
            ),
        "create_time" => $profile->create_time
    );
    
    echo json_encode(
        array("success" => 1, "message" => "Login successful.", "profile" => $data)
    );
}
 
else{
    echo json_encode(
        array("success" => 0, "message" => "Error.")
    );
}
?>