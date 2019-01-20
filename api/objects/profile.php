<?php
class Profile{

    // database connection and table name
    private $conn;
    private $table_name = "pb_user_details";

    // object properties
    public $id;
    public $user_id;
    public $firstname;
    public $lastname;
    public $mobile;
    public $landline;
    public $dob;
    public $sex;
    public $street;
    public $state;
    public $country;
    public $pincode;
    public $created_on;
    public $updated_on;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read User
    function getUserProfile(){
         // select all query
        $query = "SELECT
                    p.id, 
                    p.firstname, 
                    p.lastname, 
                    p.mobile, 
                    p.landline, 
                    p.dob, 
                    p.sex, 
                    p.street, 
                    p.state, 
                    p.country, 
                    p.pincode
                FROM
                    " . $this->table_name. 
                    " p WHERE 
                        user_id = ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // bind id
        $stmt->bindParam(1, $this->user_id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->firstname = $row['firstname'];
        $this->lastname = $row['lastname'];
        $this->mobile = $row['mobile'];
        $this->landline = $row['landline'];
        $this->dob = $row['dob'];
        $this->sex = $row['sex'];
        $this->street = $row['street'];
        $this->state = $row['state'];
        $this->country = $row['country'];
        $this->pincode = $row['pincode'];
    }

    // create User
    function createProfile(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    user_id=:user_id, 
                    firstname=:firstname, 
                    lastname=:lastname, 
                    dob=:dob";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
    
        // bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":dob", $this->dob);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // update Profile
    function updateProfile(){
        // query to update record
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    firstname=:firstname, 
                    lastname=:lastname, 
                    mobile=:mobile, 
                    landline=:landline, 
                    dob=:dob, 
                    sex=:sex, 
                    street=:street, 
                    state=:state, 
                    country=:country, 
                    pincode=:pincode,
                    updated_on= CURRENT_TIMESTAMP
                WHERE                
                    user_id=:user_id";
    
        // prepare query
        $stmt = $this->conn->prepare($query);

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


}
?>