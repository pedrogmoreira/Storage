<?php
class History {
  // database connection and table name
  private $conn;

  private $table_name =   "change_history";

  // object properties
  public $description;

  public $quantity;

  // constructor with $db_conn as database connection
  public function __construct($db_conn)
  {

        $this->conn = $db_conn;
  }

  // create category
  function create($email, $barcode)
  {

        if ($this->create_history()) {
            // query to insert record
            $query = "INSERT INTO
                        rel_change_history
                    SET
                        product_barcode=:product_barcode, profile_email=:profile_email, change_history_id=:change_history_id";
         
            // prepare query
            $stmt = $this->conn->prepare($query);
            
            // sanitize
            $barcode=htmlspecialchars(strip_tags($barcode));
            $email=htmlspecialchars(strip_tags($email));
            $id=htmlspecialchars(strip_tags($this->getLastID()));
            
         
            // bind values
            $stmt->bindParam(":product_barcode", $barcode);
            $stmt->bindParam(":profile_email", $email);
            $stmt->bindParam(":change_history_id", $id);
         
            // execute query
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        } else {
            return false;
        }
  }

  // create category
  function create_history()
  {

        
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    description=:description, quantity=:quantity";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->quantity=htmlspecialchars(strip_tags($this->quantity));
        
     
        // bind values
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":quantity", $this->quantity);
     
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

