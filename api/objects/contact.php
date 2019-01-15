<?php
class Contact{

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

    // read User
    function read(){
         // select all query
        $query = "SELECT
                    p.id, p.username, p.password, p.active
                FROM
                    " . $this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // create User
    function create(){
        function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    username=:username, password=:password, email=:email, active=:active";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=base64_encode($this->password);
        $this->email=$this->email;
        $this->active=1;
    
        // bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":active", $this->active);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }


}
