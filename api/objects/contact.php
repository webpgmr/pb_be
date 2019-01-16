<?php
class Contact{

    // database connection and table name
    private $conn;
    private $table_name = "pb_user_contact";

    // object properties
    public $id;
    public $user_id;
    public $firstname;
    public $lastname;
    public $email;
    public $mobile;
    public $landline;
    public $street;
    public $state;
    public $country;
    public $pincode;
    public $created_on;
    public $updated_on;
    public $active;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read User
    function getUserContacts(){
         // select all query
        $query = "SELECT
                    p.id,
                    p.firstname,
                    p.lastname, 
                    p.email,
                    p.mobile, 
                    p.landline, 
                    p.street, 
                    p.state, 
                    p.country, 
                    p.pincode
                FROM
                    " . $this->table_name. 
                    " WHERE 
                        user_id = ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // bind id
        $stmt->bindParam(1, $this->user_id);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // create User
    function createContact(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    user_id=:user_id, 
                    firstname=:firstname, 
                    lastname=:lastname, 
                    mobile=:mobile, 
                    landline=:landline, 
                    email=:email,
                    street=:street, 
                    state=:state, 
                    country=:country, 
                    pincode=:pincode";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->mobile=htmlspecialchars(strip_tags($this->mobile));
        $this->landline=htmlspecialchars(strip_tags($this->landline));
        $this->street=htmlspecialchars(strip_tags($this->street));
        $this->state=htmlspecialchars(strip_tags($this->state));
        $this->country=htmlspecialchars(strip_tags($this->country));
        $this->pincode=htmlspecialchars(strip_tags($this->pincode));        
    
        // bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":mobile", $this->mobile);
        $stmt->bindParam(":landline", $this->landline);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":street", $this->street);
        $stmt->bindParam(":state", $this->state);
        $stmt->bindParam(":country", $this->country);
        $stmt->bindParam(":pincode", $this->pincode);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // update Profile
    function updateContact(){
        // query to insert record
        $query = "UPDATE FROM
                    " . $this->table_name . "
                SET
                    firstname=:firstname, 
                    lastname=:lastname, 
                    mobile=:mobile, 
                    landline=:landline, 
                    email=:email, 
                    street=:street, 
                    state=:state, 
                    country=:country, 
                    pincode=:pincode
                WHERE                
                    id=:id";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->mobile=htmlspecialchars(strip_tags($this->mobile));
        $this->landline=htmlspecialchars(strip_tags($this->landline));
        $this->street=htmlspecialchars(strip_tags($this->street));
        $this->state=htmlspecialchars(strip_tags($this->state));
        $this->country=htmlspecialchars(strip_tags($this->country));
        $this->pincode=htmlspecialchars(strip_tags($this->pincode));        
    
        // bind values
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":mobile", $this->mobile);
        $stmt->bindParam(":landline", $this->landline);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":street", $this->street);
        $stmt->bindParam(":state", $this->state);
        $stmt->bindParam(":country", $this->country);
        $stmt->bindParam(":pincode", $this->pincode);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }


}
?>