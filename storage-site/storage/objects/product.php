<?php
class Product {
 
    // database connection and table name
    private $conn;
    private $table_name = "product";
 
    // object properties
    public $barcode;
    public $name;
    public $category;
    public $quantity;
    public $description;
 
    // constructor with $db_conn as database connection
    public function __construct($db_conn){
        $this->conn = $db_conn;
    }

    // read products
    function view_products(){
     
        // select all query
        $query = "SELECT * FROM Products";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
    
    function view_products_for_email($email) {
        // select all query
        $query = "SELECT
                    PD.barcode, PD.name, R.quantity, R.description, C.id_category, C.name as 'category_name'
                    FROM rel_product R
                    INNER JOIN profile PF
                    ON PF.email = R.profile_email
                    INNER JOIN product PD
                    ON PD.barcode = R.product_barcode
                    INNER JOIN category C
                    ON C.id_category = PD.category
                    WHERE PF.email = ?";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        $stmt->bindParam(1, $email);
        
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
    
    // create product
    function create(){
        // query to insert record
    	$query = "INSERT INTO
    	" . $this->table_name . "
    	SET
    	    barcode=:barcode, name=:name, category=:category";
    	
    	// prepare query
    	$stmt = $this->conn->prepare($query);
    	
    	// sanitize
    	$this->barcode=htmlspecialchars(strip_tags($this->barcode));
    	$this->name=htmlspecialchars(strip_tags($this->name));
    	
    	// bind values
    	$stmt->bindParam(":barcode", $this->barcode);
    	$stmt->bindParam(":name", $this->name);
    	$stmt->bindParam(":category", $this->category->id);
    	
    	// execute query
    	if($stmt->execute()){
    		return true;
    	}else{
    		return false;
    	}
    }
    
    // add product to user
    function add_to_email($email){
        // query to insert record
    	$query = "INSERT INTO
    	            rel_product
                SET
                	profile_email=:profile_email, product_barcode=:product_barcode, quantity=:quantity, description=:description";
    	
    	// prepare query
    	$stmt = $this->conn->prepare($query);
    	
    	// sanitize
    	$email=htmlspecialchars(strip_tags($email));
    	$this->barcode=htmlspecialchars(strip_tags($this->barcode));
    	$this->quantity=htmlspecialchars(strip_tags($this->quantity));
    	$this->description=htmlspecialchars(strip_tags($this->description));
    	
    	// bind values
    	$stmt->bindParam(":profile_email", $email);
    	$stmt->bindParam(":product_barcode", $this->barcode);
    	$stmt->bindParam(":quantity", $this->quantity);
    	$stmt->bindParam(":description", $this->description);
    	
    	// execute query
    	if($stmt->execute()){
    		return true;
    	}else{
    		return false;
    	}
    }

    // update product quantity
    function update_quantity($email){
        // query to insert record
        $query = "UPDATE
                    rel_product
                SET
                    quantity=:quantity
                WHERE profile_email=:profile_email AND product_barcode=:product_barcode";
        
        // prepare query
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $email=htmlspecialchars(strip_tags($email));
        $this->barcode=htmlspecialchars(strip_tags($this->barcode));
        $this->quantity=htmlspecialchars(strip_tags($this->quantity));
        
        // bind values
        $stmt->bindParam(":profile_email", $email);
        $stmt->bindParam(":product_barcode", $this->barcode);
        $stmt->bindParam(":quantity", $this->quantity);
        
        // execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    
    // delete product for user
    function delete($email){
        // query to insert record
        $query = "DELETE FROM
                    rel_product
                WHERE profile_email=:profile_email AND product_barcode=:product_barcode";
        
        // prepare query
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $email=htmlspecialchars(strip_tags($email));
        $this->barcode=htmlspecialchars(strip_tags($this->barcode));
        
        // bind values
        $stmt->bindParam(":profile_email", $email);
        $stmt->bindParam(":product_barcode", $this->barcode);
        
        // execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    // update product description
    function update_description($email){
        // query to insert record
        $query = "UPDATE
                    rel_product
                SET
                    description=:description
                WHERE profile_email=:profile_email AND product_barcode=:product_barcode";
        
        // prepare query
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $email=htmlspecialchars(strip_tags($email));
        $this->barcode=htmlspecialchars(strip_tags($this->barcode));
        $this->description=htmlspecialchars(strip_tags($this->description));
        
        // bind values
        $stmt->bindParam(":profile_email", $email);
        $stmt->bindParam(":product_barcode", $this->barcode);
        $stmt->bindParam(":description", $this->description);
        
        // execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    function select_history($email, $barcode) {
        // select all query
        $query = "SELECT
                    CH.description, CH.date, CH.quantity
                    FROM rel_change_history R
                    INNER JOIN change_history CH
                    ON CH.id_change_history = R.change_history_id
                    WHERE R.profile_email = ? AND R.product_barcode = ?
                    ORDER BY date DESC";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $barcode);
        
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
}