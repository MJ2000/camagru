<?php
class User{

    //database variables
    private $conn;
    private $table = "users";

    //Entries
    public $id;
    public $username;
    public $name;
    public $surname;
    public $email;
    public $password;
    public $auth;

    //construct with DB
    public function __construct( $db ){
        $this->conn = $db;
    }

    public function ft_read(){
        //Create query
        $query = "SELECT * FROM " . $this->table;

        //prep statement
        $stmt = $this->conn->prepare( $query );

        $stmt->execute();
        return ( $stmt );
    }

    public function ft_read_user(){
        //Create Query
        $query = "SELECT * FROM " . $this->table . " WHERE username = ? LIMIT 0,1";
        $stmt = $this->conn->prepare( $query );

        //Binding logins
        $stmt->bindParam( 1, $this->username );
        $stmt->execute();

        //get data
        $result = $stmt->fetch( PDO::FETCH_ASSOC );
        if( isset( $result[ "id" ] ) && isset( $result[ "email" ] ) && isset( $result[ "auth" ] )){
            $this->id = $result[ "id" ];
            $this->email = $result[ "email" ];
            $this->name = $result[ "name" ];
            $this->surname = $result[ "surname" ];
            $this->password = $result[ "password" ];
            $this->auth = $result[ "auth" ];
        }else{
            die();
        }        
    }

    //doc
    public static function doc()
	{
		return (file_get_contents('User.class.doc.txt'));
	}

    //Create User
    public function ft_create(){
        $query =  "INSERT INTO " . $this->table . " SET username=:username, name=:name, surname=:surname, email=:email, password=:password";

        //Prepare Stmt
        $stmt = $this->conn->prepare( $query );

        //Sanitize Data
        $this->username = htmlspecialchars( strip_tags( $this->username ));
        $this->name     = htmlspecialchars( strip_tags( $this->name ));
        $this->surname  = htmlspecialchars( strip_tags( $this->surname ));
        $this->email    = htmlspecialchars( strip_tags( $this->email ));
        if ( !filter_var(  $this->email , FILTER_VALIDATE_EMAIL )) {
            exit ;
        }
        $this->password = htmlspecialchars( strip_tags( $this->password ));
        
        //Data Binding
        $stmt->bindParam( ":username", $this->username );
        $stmt->bindParam( ":name", $this->name );
        $stmt->bindParam( ":surname", $this->surname );
        $stmt->bindParam( ":email", $this->email );
        $stmt->bindParam( ":password", $this->password );
        
        //exe Query
        if ( $stmt->execute() ){
            return ( true );
        }else{
            return ( false );
        }
    }

    //Update User
    public function ft_auth(){
        $query =  "UPDATE " . $this->table . " SET auth=:auth WHERE email=:email";

        //Prepare Stmt
        $stmt = $this->conn->prepare( $query );

        //Sanitize Data 
        $this->email = $this->email;
        $this->auth = "1";
        
        //Data Binding
        $stmt->bindParam( ":email", $this->email );
        $stmt->bindParam( ":auth", $this->auth );
        
        //exe Query
        if ( $stmt->execute() ){
            return ( true );
        }else{
            return ( false );
        }
    }

    //Password
    public function ft_password(){
        $query =  "UPDATE " . $this->table . " SET password=:password WHERE email=:email";

        //Prepare Stmt
        $stmt = $this->conn->prepare( $query );

        //Sanitize Data 
        $this->email = htmlspecialchars( strip_tags( $this->email ) );
        $this->password = $this->password;
        
        //Data Binding
        $stmt->bindParam( ":email", $this->email );
        $stmt->bindParam( ":password", $this->password );
        
        //exe Query
        if ( $stmt->execute() ){
            return ( true );
        }else{
            return ( false );
        }
    }

    //Profile
    public function ft_profile(){
        $query =  "UPDATE " . $this->table . " SET email=:email, username=:username, password=:password WHERE id=:id";

        //Prepare Stmt
        $stmt = $this->conn->prepare( $query );

        //Sanitize Data 
        $this->email = htmlspecialchars( strip_tags( $this->email ) );
        $this->id = htmlspecialchars( strip_tags( $this->id ) );
        $this->username = htmlspecialchars( strip_tags( $this->username ) );
        $this->password = htmlspecialchars( strip_tags( $this->password ) );
        
        //Data Binding
        $stmt->bindParam( ":email", $this->email );
        $stmt->bindParam( ":password", $this->password );
        $stmt->bindParam( ":username", $this->username );
        $stmt->bindParam( ":id", $this->id );
        
        //exe Query
        if ( $stmt->execute() ){
            return ( true );
        }else{
            return ( false );
        }
    }
}  