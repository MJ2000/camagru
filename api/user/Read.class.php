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

//Get logins
$usr->username = isset( $_GET[ "username" ]) ? $_GET[ "username" ] : die();

//Read User
$usr->ft_read_user();

if ( isset( $usr->username )){
    $aryUser = array(
        "id" => $usr->id,
        "username" => $usr->username,
        "name" => $usr->name,
        "surname" => $usr->surname,
        "email" => $usr->email,
        "password" => $usr->password,
        "auth" => $usr->auth
    );
}
else{
    echo json_encode( array( "message" => "Invalid user. Please register or login." ));
}

//JSON ENCODE
print_r( json_encode( $aryUser ) );