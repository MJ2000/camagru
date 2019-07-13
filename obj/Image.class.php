<?php

class Image{

    //database variables
    private $conn;
    private $table = "images";
    private $likes_table = "likes";
    private $comments_table = "comments";

    //Entries
    public $user_id;
    public $img_id;
    public $title;
    public $location;
    public $count;
    public $body;

    //construct with DB
    public function __construct( $db ){
        $this->conn = $db;
    }

    public function ft_upload(){
        $query =  "INSERT INTO " . $this->table . " SET user_id=:user_id, title=:title, location=:location";
        
        //Prepare Stmt
        $stmt = $this->conn->prepare( $query );

        //Sanitize Data
        $this->user_id =     htmlspecialchars( $this->user_id );
        $this->title =       htmlspecialchars( $this->title );
        $this->location =    htmlspecialchars( $this->location );
        
        //Data Binding
        $stmt->bindParam( ":user_id",   $this->user_id );
        $stmt->bindParam( ":title",     $this->title );
        $stmt->bindParam( ":location",  $this->location );

        //exe Query
        if ( $stmt->execute() ){
            return ( true );
        }else{
            return ( false );
        }
    }

    public function ft_read( $from ){
        $query = "SELECT * FROM $this->table   ORDER BY $this->table.created DESC ";
        
        //prep statement
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return ( $stmt );
    }

    public function ft_delete(){
        $query = "DELETE FROM $this->table WHERE id = ?";

        //prep statement
        $stmt = $this->conn->prepare( $query );

        //Data Binding
        $stmt->bindParam(1 , $this->id );

        $stmt->execute();
        return ( $stmt );
    }

    public function ft_delete_comments(){
        $query = "DELETE FROM $this->comments_table WHERE img_id = ?";

        //prep statement
        $stmt = $this->conn->prepare( $query );

        //Data Binding
        $stmt->bindParam(1 , $this->id );

        $stmt->execute();
        return ( $stmt );
    }
    public function ft_delete_likes(){
        $query = "DELETE FROM $this->likes_table WHERE img_id = ?";

        //prep statement
        $stmt = $this->conn->prepare( $query );

        //Data Binding
        $stmt->bindParam(1 , $this->id );

        $stmt->execute();
        return ( $stmt );
    }

    public function ft_read_likes(){
        //Create query
        $query = "SELECT COUNT(likes_count) as tot_likes, likes.img_id FROM $this->likes_table GROUP BY likes.img_id";
         //prep statement
        $stmt = $this->conn->prepare( $query );

        $stmt->execute();
        return ( $stmt );
    }
    
    public function ft_read_comments(){
       //Create query
        
       $query = "SELECT * FROM " . $this->comments_table;
       //prep statement
       $stmt = $this->conn->prepare( $query );

       $stmt->execute();
       return ( $stmt );
    }

    public function ft_comment(){
        $query =  "INSERT INTO " . $this->comments_table . " SET img_id=:img_id, body=:body";
        
        //Prepare Stmt
        $stmt = $this->conn->prepare( $query );

        //Sanitize Data
        $this->img_id =          htmlspecialchars( $this->img_id );
        $this->body =            htmlspecialchars( $this->body );
        
        //Data Binding
        $stmt->bindParam( ":img_id",            $this->img_id );
        $stmt->bindParam( ":body",              $this->body );

        //exe Query
        if ( $stmt->execute() ){
            return ( true );
        }else{
            return ( false );
        }
    }

    public static function doc()
	{
		return (file_get_contents('Image.class.doc.txt'));
	}

    public function ft_like(){
        $query =  "INSERT INTO " . $this->likes_table . " SET img_id=:img_id, likes_count=:count";
        
        //Prepare Stmt
        $stmt = $this->conn->prepare( $query );

        //Sanitize Data
        $this->img_id =           htmlspecialchars( $this->img_id );
        $this->count =            htmlspecialchars( $this->likes_count );
        
        //Data Binding
        $stmt->bindParam( ":img_id",           $this->img_id );
        $stmt->bindParam( ":count",            $this->count );

        //exe Query
        if ( $stmt->execute() ){
            return ( true );
        }else{
            return ( false );
        }
    }

}  