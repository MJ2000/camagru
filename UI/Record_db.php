<?php
    session_start();

    $tmp = $_GET[ "location" ];
    $name = $_GET[ "name" ];
    $location = str_replace( $name, "", $tmp );
    $id = $_SESSION[ 'id' ];
    
    if ( !empty( $name ) && !empty( $location )){
        $url = "http://127.0.0.1:8080/camagru/api/Image/Create.class.php";
        $data = json_encode( array ("user_id"=> $id,
                    "title" => $name,
                    "location" => $location ));
        $ch = curl_init( $url );

        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen( $data )));
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );

        $results = curl_exec( $ch );
        if ( $results === FALSE ){
            echo "SHIT";
        }else{
            echo "Recorded";
        }
        curl_close( $ch );
        echo $results;
    }else{
        echo "Not recorded";
    }

?>