<?php
//headers
header( "Access-Control-Allow-Origin: *" );
header( "Content-Type: application/json;" );
header( "Access-Control-Allow-Methods: PUT" );
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

$usr->auth = $data->auth;
$usr->email = $data->email;

//Authenticating User
if ( $usr->ft_auth() ){
    print( json_encode( array( "message" => "Sucess: User has been authenticated" )));
}else{
    print( json_encode( array( "message" => "Error: Unable to authenticate user" )));
}