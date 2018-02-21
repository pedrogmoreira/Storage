<?php
class Address{
 
    // database connection and table name
    private $conn;
    private $table_name = "address";
 
    // object properties
    public $id;
	public $cep;
	public $public_place;
	public $complement;
	public $neighborhood;
	public $city;
	public $state;
	public $state_uf;
	public $country;
	public $number;
	
	// create profile
    function create($conn){
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    cep=:cep, number=:number, public_place=:public_place, complement=:complement, neighborhood=:neighborhood, city=:city, state=:state, state_uf=:state_uf";
     
        // prepare query
        $stmt = $conn->prepare($query);
     
        // sanitize
        $this->cep=htmlspecialchars(strip_tags($this->cep));
        $this->number=htmlspecialchars(strip_tags($this->number));
        $this->public_place=htmlspecialchars(strip_tags($this->public_place));
        $this->complement=htmlspecialchars(strip_tags($this->complement));
        $this->neighborhood=htmlspecialchars(strip_tags($this->neighborhood));
        $this->city=htmlspecialchars(strip_tags($this->city));
        $this->state=htmlspecialchars(strip_tags($this->state));
        $this->state_uf=htmlspecialchars(strip_tags($this->state_uf));
        
        // bind values
        $stmt->bindParam(":cep", $this->cep);
        $stmt->bindParam(":number", $this->number);
        $stmt->bindParam(":public_place", $this->public_place);
        $stmt->bindParam(":complement", $this->complement);
        $stmt->bindParam(":neighborhood", $this->neighborhood);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":state", $this->state);
        $stmt->bindParam(":state_uf", $this->state_uf);
     
        // execute query
        if($stmt->execute()){
            return $conn->lastInsertId(); 
        }else{
            return false;
        }
    }

    // update user
    function update($conn){
        // query to insert record
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    cep=:cep, number=:number, public_place=:public_place, complement=:complement, neighborhood=:neighborhood, city=:city, state=:state, state_uf=:state_uf
                WHERE
                    id_address=:id_address";
     
        // prepare query
        $stmt = $conn->prepare($query);
     
        // sanitize
        $this->cep=htmlspecialchars(strip_tags($this->cep));
        $this->number=htmlspecialchars(strip_tags($this->number));
        $this->public_place=htmlspecialchars(strip_tags($this->public_place));
        $this->complement=htmlspecialchars(strip_tags($this->complement));
        $this->neighborhood=htmlspecialchars(strip_tags($this->neighborhood));
        $this->city=htmlspecialchars(strip_tags($this->city));
        $this->state=htmlspecialchars(strip_tags($this->state));
        $this->state_uf=htmlspecialchars(strip_tags($this->state_uf));
        
        // bind values
        $stmt->bindParam(":cep", $this->cep);
        $stmt->bindParam(":number", $this->number);
        $stmt->bindParam(":public_place", $this->public_place);
        $stmt->bindParam(":complement", $this->complement);
        $stmt->bindParam(":neighborhood", $this->neighborhood);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":state", $this->state);
        $stmt->bindParam(":state_uf", $this->state_uf);
        $stmt->bindParam(":id_address", $this->id);
     
        // execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}
?>