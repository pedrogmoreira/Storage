<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate profile object
include_once '../objects/profile.php';
include_once '../objects/user.php';
include_once '../objects/address.php';

if ($_POST) {
    $database = new Database();
    $db_conn = $database->getConnection();
     
    $profile = new profile($db_conn);
     
    // set profile property values
    $address = new Address;
    $address->cep = $_POST["cep"];
    $address->number = $_POST["number"];
    $address->public_place = $_POST["public_place"];
    $address->complement = $_POST["complement"];
    $address->neighborhood = $_POST["neighborhood"];
    $address->city = $_POST["city"];
    $address->state_uf = $_POST["state_uf"];
    $address->state = $_POST["state"];
    
    $user = new User;
    $user->cpf = $_POST["cpf"];
    $user->first_name = $_POST["first_name"];
    $user->last_name = $_POST["last_name"];
    $user->birth_date = $_POST["birth_date"];
    $user->address = $address;
    
    $profile->email = $_POST["email"];
    $profile->password = $_POST["password"];
    $profile->user = $user;
    
    // create the profile
    if($profile->create()){
        echo '{';
            echo '"success" : 1,"message" : "Usuário criado com sucesso."';
        echo '}';
    }
    // if unable to create the profile, tell the user
    else{
        echo '{';
            echo '"success" : 0,
                    "message": "Não foi possível criar o usuário."';
        echo '}';
    }
} else {
    echo '{';
        echo '"success" : 2,"message": "É requerida uma requisição POST."';
    echo '}';
}
?>