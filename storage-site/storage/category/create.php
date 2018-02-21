<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate category object
include_once '../objects/category.php';

if ($_POST) {
    $database = new Database();
    $db_conn = $database->getConnection();
     
    $category = new Category($db_conn);
     
    // set category property values
    
    
    $category->name = $_POST["name"];
    
    // create the category
    if($category->create()){
        echo '{';
            echo '"success" : 1,"message" : "Categoria criada com sucesso.", "id": ' . $category->getLastID();
        echo '}';
    }
    // if unable to create the category, tell the user
    else{
        echo '{';
            echo '"success" : 0,
                    "message": "Não foi possível criar a categoria."';
        echo '}';
    }
} else {
    echo '{';
        echo '"success" : 2,"message": "É requerida uma requisição POST."';
    echo '}';
}
?>