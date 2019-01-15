<?php
class Token{

    // database connection and table name
    private $conn;
    private $table_name = "pb_user_token";

    // object properties
    public $id;
    public $user_id;
    public $token;
    public $created_on;
    public $updated_on;
    public $active;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read Token
    function getUserToken(){
         // select all query
        $query = "SELECT
                    p.token
                FROM
                    " . $this->table_name. " WHERE user_id = ? and active = 1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id
        $stmt->bindParam(1, $this->user_id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->token = $row['token'];

        return $this->token;
    }

    // create Token
    function generateToken(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    user_id=:user_id, token=:token, active=:active";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        $this->token = '';
        $this->active=1;
    
        // bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":token", $this->token);
        $stmt->bindParam(":active", $this->active);
    
        // execute query
        if($stmt->execute()){
            return $this->token;
        }
    
        return '';        
    }

    // update token 
    function updateToken() {
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    token = :token,
                    updated_on = CURRENT_TIMESTAMP                   
                WHERE
                    user_id = :user_id";
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        $random = rand(200, 3000);
        $this->token = base64_encode($this->user_id+$random);

        // bind new values
        $stmt->bindParam(':token', $this->token);
        $stmt->bindParam(':user_id', $this->user_id);
    
        // execute the query
        if($stmt->execute()){
            return $this->token;
        }
    
        return '';
    }


}