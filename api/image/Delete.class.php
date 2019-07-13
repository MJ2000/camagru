<?php
//headers
header( "Access-Control-Allow-Origin: *" );
header( "Content-Type: application/json;" );
header( "Access-Control-Allow-Methods: DELETE" );
header( "Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With" );

//database objects
include_once "../../config/Database.class.php";
include_once "../../obj/Image.class.php";

//Create && Connectdb
$database = new Database();
$db = $database->ft_connect();
$img = new Image( $db );

//Read data
$data = json_decode( file_get_contents( "php://input" ) );
$img->id = $data->id;

//Authenticating User
if ( $img->ft_delete() ){
     $img->ft_delete_likes();
     $img->ft_delete_comments();
    print( json_encode( array( "message" => "Deleted" )));
}else{
    print( json_encode( array( "message" => "Not Deleted" )));
}