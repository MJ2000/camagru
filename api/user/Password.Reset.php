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

$usr->email = $data->email;
$usr->password = password_hash( $data->password, PASSWORD_DEFAULT );

//Authenticating User
if ( $usr->ft_password() ){
    print( json_encode( array( "message" => "Authenticated" )));
}else{
    print( json_encode( array( "message" => "Error: Trouble authenticating" )));
}