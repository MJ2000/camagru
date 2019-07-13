<?php
//headers
//User
header( "Access-Control-Allow-Origin: *" );
header( "Content-Type: application/json;" );
header( "Access-Control-Allow-Methods: POST" );
header( "Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With" );

//database objects
include_once "../../config/Database.class.php";
include_once "../../obj/User.class.php";

//Create && Connectdb
$database = new Database();

$db = $database->ft_connect();
$usr = new User( $db );

//Get Data from HTML
$data = json_decode( file_get_contents( "php://input" ));

if ( !empty( $data->name ) ){    
    $usr->username = $data->username;
    $usr->name = $data->name;
    $usr->surname = $data->surname;
    $usr->email = $data->email;
    $usr->password = password_hash( $data->password, PASSWORD_DEFAULT );
}else{
    print( json_encode( array( "message" => "Make sure you have filled in all the fields" )));
    die();
}

//Creating User
if ( $usr->ft_create() ){
    print( json_encode( array( "message" => "Check your email for verification")));
}else{
    print( json_encode( array( "message" => "Error Occured" )));
}