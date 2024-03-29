<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/category.php';
 
// instantiate database and category object
$database = new Database();
$db_conn = $database->getConnection();
 
// initialize object
$category = new Category($db_conn);
 
// query categories
$stmt = $category->view_categories();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // categories array
    $categories_arr=array();
    $categories_arr["categories"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $category_item=array(
            "id" => $id_category,
            "name" => $name,
        );
 
        array_push($categories_arr["categories"], $category_item);
        //$categories_arr["categories"]=$category_item;
        //unset($category_item);
    }
 
    echo json_encode($categories_arr);
}
 
else{
    echo json_encode(
        array("error" => "No categories found.")
    );
}
?>