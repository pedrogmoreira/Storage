<?php
include_once '../objects/user.php';
include_once '../objects/address.php';

class Profile{
 
    // database connection and table name
    private $conn;
    private $table_name = "profile";
 
    // object properties
    public $email;
    public $password;
    public $user;
    public $create_time;
 
    // constructor with $db_conn as database connection
    public function __construct($db_conn){
        $this->conn = $db_conn;
    }
    
    function getLastID() {
        return $this->conn->lastInsertId();
    }

    // used when filling up the update product form
    function login(){
        // query to read single record
        $query = "SELECT * FROM " . $this->table_name . " P
                INNER JOIN user U
                ON U.id_user = P.user
                INNER JOIN address A
                ON A.id_address = U.address
                WHERE email = ? AND password = ?";
                
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(1, $this->email);
        $stmt->bindParam(2, md5($this->password));

        // execute query
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!empty($row)) {
            $address = new Address;
            $address->id = $row['id_address']; 
            $address->cep = $row['cep'];
            $address->public_place = $row['public_place'];
            $address->complement = $row['complement'];
            $address->neighborhood = $row['neighborhood'];
            $address->city = $row['city'];
            $address->state = $row['state'];
            $address->state_uf = $row['state_uf'];
            $address->country = $row['country'];
            $address->number = $row['number'];
            
            $user = new User;
            $user->id = $row['id_user'];
            $user->cpf = $row['cpf'];
            $user->first_name = $row['first_name'];
            $user->last_name = $row['last_name'];
            $user->birth_date = $row['birth_date'];
            $user->address = $address;
            
            $this->user = $user;
            $this->create_time = $row['create_time'];
        }
    }
    
    // create profile
    function create(){
        $user_id = $this->user->create($this->conn);
        
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    email=:email, password=:password, user=:user";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
     
        // bind values
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":user", $user_id);
     
        // execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    
    // update profile
    function update(){
        if($this->user->update($this->conn)){
            return true;
        }else{
            return false;
        }
    }

    // create profile
    function change_password(){
        // query to insert record
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    password=:password
                WHERE
                	email=:email";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
     
        // bind values
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
     
        // execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}