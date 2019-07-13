<?php
//headers
header( "Access-Control-Allow-Origin: *" );
header( "Content-Type: application/json;" );

//database objects
include_once "../../config/Database.class.php";
include_once "../../obj/User.class.php";

//Create && Connectdb
$database = new Database();
$db = $database->ft_connect();

$usr = new User($db);

//query db
$results = $usr->ft_read();
//get Obj count
$numRows = $results->rowCount();

if ( $numRows > 0 ){
    $aryUsers = array();
    //set user data array
    $aryUsers[ "data" ] = array();

    //receieve user data
    while ( $row = $results->fetch( PDO::FETCH_ASSOC )){
        //extract keys
        extract( $row );

        $user = array(
            "id"        => $id,
            "username"  => $username,
            "name"      => $name,
            "surname"   => $surname,
            "email"     => $email,
            "password"  => $password,           
            "auth"      => $auth            
        );

        //push entity into data ary
        array_push( $aryUsers[ "data" ], $user);
    }
    echo json_encode( $aryUsers );
}
else{
    echo json_encode(
         array("message" => "Invalid user. Please regisrer or sign in" )
    );
}