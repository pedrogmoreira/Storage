<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';
 
// instantiate database and product object
$database = new Database();
$db_conn = $database->getConnection();
 
// initialize object
$product = new Product($db_conn);
 
// query products
$stmt = $product->view_products();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $products_arr=array();
    $products_arr["products"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $product_item=array(
            "barcode" => $barcode,
            "name" => $name,
            "category_id" => $category_id,
            "category_name" => $category_name
        );
 
        array_push($products_arr["products"], $product_item);
        //$products_arr["products"]=$product_item;
        //unset($product_item);
    }
 
    echo json_encode($products_arr);
}
 
else{
    echo json_encode(
        array("error" => "No products found.")
    );
}
?>