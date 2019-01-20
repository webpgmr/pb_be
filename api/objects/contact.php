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

    // get Contact 
    function getUserContacts(){
         // select all query
        $query = "SELECT
                    id,
                    firstname,
                    lastname, 
                    email,
                    dob,
                    sex, 
                    mobile,
                    landline, 
                    street, 
                    state, 
                    country, 
                    pincode
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

    // create Contact
    function createContact(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    user_id=:user_id, 
                    firstname=:firstname, 
                    lastname=:lastname, 
                    mobile=:mobile, 
                    dob=:dob,
                    sex=:sex,
                    landline=:landline, 
                    email=:email,
                    street=:street, 
                    state=:state, 
                    country=:country, 
                    pincode=:pincode,
                    created_on= CURRENT_TIMESTAMP,
                    active=1";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->mobile=htmlspecialchars(strip_tags($this->mobile));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->landline=htmlspecialchars(strip_tags($this->landline));
        $this->street=htmlspecialchars(strip_tags($this->street));
        $this->state=htmlspecialchars(strip_tags($this->state));
        $this->pincode=htmlspecialchars(strip_tags($this->pincode));        
    
        // bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":mobile", $this->mobile);
        $stmt->bindParam(":landline", $this->landline);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":dob", $this->dob);
        $stmt->bindParam(":sex", $this->sex);
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

    // update Contact
    function updateContact(){
        // query to insert record
        $query = "UPDATE 
                    " . $this->table_name . "
                SET
                    firstname=:firstname, 
                    lastname=:lastname, 
                    mobile=:mobile, 
                    landline=:landline, 
                    dob=:dob,
                    sex=:sex,
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
        $stmt->bindParam(":dob", $this->dob);
        $stmt->bindParam(":sex", $this->sex);
        $stmt->bindParam(":street", $this->street);
        $stmt->bindParam(":state", $this->state);
        $stmt->bindParam(":country", $this->country);
        $stmt->bindParam(":pincode", $this->pincode);
        $stmt->bindParam(":id", $this->id);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete Contact
    function deleteContact(){
        // query to insert record
        $query = "DELETE FROM 
                    " . $this->table_name . "
                  WHERE                
                    id= ?";
    
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
}
?>