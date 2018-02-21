<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate history object
include_once '../objects/history.php';

if ($_POST) {
    $database = new Database();
    $db_conn = $database->getConnection();
     
    $history = new History($db_conn);
     
    // set history property values
    
    
    $history->description = $_POST["description"];
    $history->quantity = $_POST["quantity"];
    $email = $_POST["email"];
    $barcode = $_POST["barcode"];
    
    // create the history
    if($history->create($email, $barcode)){
        echo '{';
            echo '"success" : 1,"message" : "Histórico adicionado com sucesso."';
        echo '}';
    }
    // if unable to create the history, tell the user
    else{
        echo '{';
            echo '"success" : 0,
                    "message": "Não foi possível adicionar o histórico."';
        echo '}';
    }
} else {
    echo '{';
        echo '"success" : 2,"message": "É requerida uma requisição POST."';
    echo '}';
}
?>