<?php

 //reseting password
function new_password( $email ){
    $url = "http://localhost:8080/camagru/api/user/Password.Reset.php";
    $data = json_encode(array (
            "email"=> $email,
            "password" => "HelloWorld911" ));
    $ch = curl_init($url);
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen( $data )));
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_POST, 1 );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );

    $result = curl_exec( $ch );

    if ( $result === FALSE ){
        echo "SHIT";
    } else {
        echo "Check your $email okay";
    }
}

//Deleting a pic
if ( isset( $_POST[ 'delete_id' ] )){
    $url = "http://127.0.0.1:8080/camagru/api/image/Delete.class.php";
    $data = json_encode(array (
            "id" => $_POST[ 'delete_id' ] ));
    $ch = curl_init( $url );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen( $data )));
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );

    $result = curl_exec( $ch );

    if ( $result === FALSE ){
        echo "damn";
    } else {
        Header( 'Location: Timeline.php' );
    }
   
}

//Super Imposing
function copypix( $img, $sticker ){
    $im = imagecreatefrompng( $img );
    $stamp = imagecreatefrompng( $sticker );
    $marge_right = 10;
    $marge_bottom = 10;
    $sx = imagesx( $stamp );
    $sy = imagesy( $stamp );
    imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
    imagepng($im, $img);
    imagedestroy($im);
}