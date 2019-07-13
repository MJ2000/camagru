<?php
//headers
header( "Access-Control-Allow-Origin: *" );
header( "Content-Type: application/json;" );

//database objects
include_once "../../config/Database.class.php";
include_once "../../obj/Image.class.php";

//Create && Connectdb
$database = new Database();

$db = $database->ft_connect();
if ( $_POST[ 'page' ] <= 1){
    $from = 0;
} else {
    $from = 5 * $_POST[ 'page' ];
}

$image = new Image( $db );

//query db
$results = $image->ft_read( $from );

$res = $image->ft_read_likes();
$lrows = $image->ft_read_likes();

$ret = $image->ft_read_comments();
$crows = $image->ft_read_comments();
$aryImages = array();

if ( $crows > 0 ){
    $aryImages = array();
    $aryImages[ "comments" ] = array();
    while (  $Comm = $ret->fetch( PDO::FETCH_ASSOC ) ){
        extract( $Comm );
        $Comms = array(
            "img_id"       => $img_id,
            "body"         => $body
        );
        array_push( $aryImages[ "comments" ], $Comms);
    }
}

if ( $lrows > 0 ){
    
    $aryImages[ "likes" ] = array();
    while (  $Like = $res->fetch( PDO::FETCH_ASSOC ) ){
        extract( $Like );
        $Likes = array(
            "img_id"       => $img_id,
            "tot_likes"    => $tot_likes
        );
        array_push( $aryImages[ "likes" ], $Likes);      
    }
}

//get Obj count
$numRows = $results->rowCount();

if ( $numRows > 0 ){
    $aryImages[ "data" ] = array();

    //receieve Image data
    while ( $row = $results->fetch( PDO::FETCH_ASSOC )){
        
        //extract keys
        extract( $row );
        $Image = array(
            "id"         => $id,
            "title"      => $title,
            "location"   => $location,
            "user_id"    => $user_id,
            "created"    => $created 
        );

        //push entity into data ary
        array_push( $aryImages[ "data" ], $Image);
    }    
    echo json_encode( $aryImages );
}
else{
    echo json_encode(
         array("message" => "No Images present" )
    );
}