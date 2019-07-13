<?php
include 'Database.php';
//adding doc
include "Database.class.doc.txt";
//core connection to database 
class Database{
    //Database Parameters
    public $conn;

    //DB connect
    public function ft_connect(){
        $this->conn = null;
        try{
            $this->conn = new PDO( $GLOBALS[ 'DB_DSN' ] . "dbname=" . $GLOBALS[ 'DB_NAME' ], $GLOBALS[ 'DB_USER' ], $GLOBALS[ 'DB_PASSWORD' ] );
            $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }catch ( PDOException $e ){
            print ( "Error : " . $e->getMessage() );
        }
        return ( $this->conn );
    }
}