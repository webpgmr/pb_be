<?php
class User{

    // database connection and table name
    private $conn;
    private $table_name = "pb_users";

    // object properties
    public $id;
    public $username;
    public $password;
    public $email;
    public $created_on;
    public $updated_on;
    public $last_logged_in;
    public $active;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // checking username or email already exists
    function validateUser(){
        // select all query
        $query = "SELECT
                        u.id
                    FROM
                        " . $this->table_name . 
                        " u WHERE username=:username OR 
                        email=:email and 
                        active=1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        // execute query
        $stmt->execute();

        return $stmt;
    }
    // create User
    function createUser(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    username=:username, 
                    password=:password, 
                    email=:email, 
                    active=:active";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=base64_encode($this->password);
        $this->email=$this->email;
        $this->active=1; // by default setting account active
    
        // bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":active", $this->active);
    
        // execute query
        if($stmt->execute()){
            $this->id =  $this->conn->lastInsertId();            
        }else{
            $this->id = 0;
        }
    
        return $this->id;        
    }

    function login(){
        // select all query
        $query = "SELECT
                    id
                    FROM
                " . $this->table_name . 
                    " WHERE 
                        password=:password AND 
                        :username IN ( username, email ) AND
                        active=1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $this->password = base64_encode($this->password);

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        // execute query
        $stmt->execute();

        return $stmt;
    }
    
    // delete the user
    function delete(){
    
        // delete query
        $query = "DELETE FROM " . 
            $this->table_name . 
            " WHERE id = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind id of record to delete
        $stmt->bindParam(1, $this->id);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // change password
    function changePassword () {
        // update query
        $query = "UPDATE " . 
                    $this->table_name . "
                    SET
                        password =:password,
                        updated_on= CURRENT_TIMESTAMP
                    WHERE
                        id = :user_id";
        
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->password = base64_encode($this->password);
    
        // bind id of record to update
        $stmt->bindParam(":user_id", $this->id);
        $stmt->bindParam(":password", $this->password);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

}
?>