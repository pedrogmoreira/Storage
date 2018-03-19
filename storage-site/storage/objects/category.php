<?php
class Category {
  // database connection and table name
  private $conn;

  private $table_name =   "category";

  // object properties
  public $id;

  public $name;

  // constructor with $db_conn as database connection
  public function __construct($db_conn)
  {

        $this->conn = $db_conn;
  }

  // read products
  function view_categories()
  {

     
        // select all query
        $query = "SELECT * FROM Categories
                    ORDER BY name";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
  }

  // create category
  function create()
  {

        
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
     
        // bind values
        $stmt->bindParam(":name", $this->name);
     
        // execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
  }

  function getLastID()
  {

        return $this->conn->lastInsertId();
  }

}

