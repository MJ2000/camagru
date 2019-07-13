<?php
// ini_set('display_errors', 1);
session_start();
include "../obj/Image.class.php";
require "Functions.php";

$img = $_POST[ 'img' ];
$filter = $_POST[ 'filter' ];

$dest = "../assets/images/";

if ( !empty( $img )) {
    
    $img =  explode(',' , $img, 2 );    

    $newName = $_SESSION[ 'id' ] . uniqid( "_", true) . ".png";

    $image = $dest . $newName;

    $ifp = fopen($image , "wb" );

    $todecode = str_replace(' ','+',$img[1]);

    if ( fwrite( $ifp, base64_decode( $todecode ))){

        copypix( "../assets/images/$newName" , $filter );
        header ( "Location: Record_db.php?name=$newName&location=$image" );
    }else{
        echo "Shitt";
    }
    fclose ( $ifp );
}

