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
    $profile->email = $_POST["email"];
    $profile->password = $_POST["password"];
   
    // create the profile
    if($profile->change_password()){
        echo '{';
            echo '"success" : 1,"message" : "Senha atualizada com sucesso."';
        echo '}';
    }
    // if unable to create the profile, tell the user
    else{
        echo '{';
            echo '"success" : 0,
                    "message": "Não foi possível atualizar a senha."';
        echo '}';
    }
} else {
    echo '{';
        echo '"success" : 2,"message": "É requerida uma requisição POST."';
    echo '}';
}
?>