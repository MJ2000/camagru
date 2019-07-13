<?php

session_start();

//headers
header( "Access-Control-Allow-Origin: *" );
header( "Content-Type: application/json;" );
header( "Access-Control-Allow-Methods: POST" );
header( "Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With" );

//database objects
include_once "../../config/Database.class.php";
include_once "../../obj/Image.class.php";

//Create && Connectdb
$database = new Database();
$db = $database->ft_connect();
$img = new Image( $db );

//Get Data from HTML
$data = json_decode( file_get_contents( "php://input" ) );

if ( !empty( $data->user_id ) && !empty($data->title ) && !empty( $data->location )){
    $img->user_id = $data->user_id;
    $img->title = $data->title;
    $img->location = $data->location;
    //Recording Image
    if ( $img->ft_upload() ){
        print( json_encode( array( "message" => "Image Sent" )));
    }
}
//Like function
else if ( !empty( $data->likes_count )){
    $img->img_id =            $data->img_id;
    $img->likes_count =       $data->likes_count;

    //Recording Image
    if ( $img->ft_like() ){
        print( json_encode( array( "message" => $data->likes_count )));
    }
}
else if ( !empty( $data->body )){
    $img->img_id =     $data->img_id;
    $img->body =       $data->body;
    //Recording Image
    if ( $img->ft_comment() ){
        print( json_encode( array( "body" => $data->body )));
    }else{
        print( json_encode( array( "message" => "Comment Failed" )));
    }
    
}else{
    die();
}

