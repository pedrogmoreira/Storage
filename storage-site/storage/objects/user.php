<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "user";
 
    // object properties
    public $id;
    public $cpf;
    public $first_name;
    public $last_name;
    public $birth_date;
    public $address;
    
    // create user
    function create($conn){
        $address_id = $this->address->create($conn);
        
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    cpf=:cpf, first_name=:first_name, last_name=:last_name, birth_date=:birth_date, address=:address";
     
        // prepare query
        $stmt = $conn->prepare($query);
     
        // sanitize
        $this->cpf=htmlspecialchars(strip_tags($this->cpf));
        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->birth_date=htmlspecialchars(strip_tags($this->birth_date));
     
        // bind values
        $stmt->bindParam(":cpf", $this->cpf);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":birth_date", $this->birth_date);
        $stmt->bindParam(":address", $address_id);
     
        // execute query
        if($stmt->execute()){
            return $conn->lastInsertId();
        }else{
            return false;
        }
    }
    
    // update user
    function update($conn){
        if ($this->address->update($conn)) {
            // query to insert record
            $query = "UPDATE
                        " . $this->table_name . "
                    SET
                        first_name=:first_name, last_name=:last_name, birth_date=:birth_date
                    WHERE
                        id_user=:id_user";
         
            // prepare query
            $stmt = $conn->prepare($query);
         
            // sanitize
            $this->first_name=htmlspecialchars(strip_tags($this->first_name));
            $this->last_name=htmlspecialchars(strip_tags($this->last_name));
            $this->birth_date=htmlspecialchars(strip_tags($this->birth_date));
         
            // bind values
            $stmt->bindParam(":first_name", $this->first_name);
            $stmt->bindParam(":last_name", $this->last_name);
            $stmt->bindParam(":birth_date", $this->birth_date);
            $stmt->bindParam(":id_user", $this->id);
         
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
}
?>