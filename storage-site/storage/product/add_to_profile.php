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
include_once '../objects/product.php';
include_once '../objects/category.php';

if ($_POST) {
    $database = new Database();
    $db_conn = $database->getConnection();
     
    $product = new Product($db_conn);
     
    // set product property values
    $product->barcode = $_POST["barcode"];
    $product->quantity = $_POST["quantity"];
    $product->description = $_POST["description"];
    $email = $_POST["email"];
    
    // create the product
    if($product->add_to_email($email)){
        echo '{';
            echo '"success" : 1,"message" : "Produto adicionado ao perfil com sucesso."';
        echo '}';
    }
    // if unable to create the product, tell the user
    else{
        echo '{';
            echo '"success" : 0,
                    "message": "Não foi possível adicionar o produto ao perfil."';
        echo '}';
    }
} else {
    echo '{';
        echo '"success" : 2,"message": "É requerida uma requisição POST."';
    echo '}';
}
?>