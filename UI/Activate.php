<?php

    //Get Registration info
    //And Activate

    if (  $_GET[ "activate" ] ){
        
        $url = "http://localhost:8080/camagru/api/user/Auth.class.php?email=" . $_GET[ "email" ];
        $data = json_encode(array (
                    "email"=> $_GET[ "email" ] ));
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
            header( "Location: Login.php" );
        }
    }
?>