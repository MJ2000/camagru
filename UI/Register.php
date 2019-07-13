<?php

include "Nav.php";

if ( isset( $_POST[ "Register" ])){
    
    if( filter_has_var( INPUT_POST, "Register" )){
        //Get Form Data

        $username   = htmlspecialchars( strip_tags( $_POST[ "username" ] ));
        $name       = htmlspecialchars( strip_tags( $_POST[ "name" ] ));
        $surname    = htmlspecialchars( strip_tags( $_POST[ "surname" ] ));
        $email      = htmlspecialchars( strip_tags( $_POST[ "email" ] ));
        $password   = htmlspecialchars( $_POST[ "password" ] );

        //set sessions
        $_SESSION[ 'email' ] = $_POST[ "email" ];
    }

    //Check Empty Fields
    if ( !empty( $password ) && !empty( $name ) && !empty( $email )){
        $url = "http://127.0.0.1:8080/camagru//api/user/Create.class.php";
        $data = json_encode(array (
                "username"=>$username,
                "name"=> $name,
                "surname"=> $surname,
                "email"=> $email,
                "password"=> $password ));
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen( $data )));
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );

        $result = curl_exec( $ch );

        if ( $result === FALSE ){
            echo "SHIT";
        } else {
            $to = $email;
            $key = uniqid( "", true );
            $subject = "VERIFY EMAIL: ";
            $message = "Please click the link to activate your email" . "\r\n";
            $message .= "http://127.0.0.1:8080/camagru/UI/Activate.php?email=$email&activate=$key";
            $headers =  "MIME-VERSION : 1.0" . "\r\n";
            $headers .= "CONTENT-TYPE : text/html; charset = UTF-8 " . "\r\n";
            $headers .= "From : alathantonga@gmail.com" . "\r\n";
            $headers .= "Reply-To : no-reply" . "\r\n";

           if ( mail ($to, $subject, $message, $headers )){ 
                echo 'Sucess!';           
            }else { 
               echo 'Error Occured';  
            } 
        }
        curl_close( $ch );
        print_r( json_decode( $result, true )[ 'message' ] ); 

    } else { 
        echo ( "Fill In all fields" ); 
    }  
} 
?>

</div><!--End of alert-->

<?php include "Header.php" ?>

<div class="container" method="POST" action=" <?php echo $_SERVER[ 'PHP_SELF' ]; ?>">
    <form class="jumbotron" method="post">
        <div class="form-group">
            <label>Username</label>
                <input name="username" type="input" value ="<?php echo isset( $_POST[ "username" ] ) ? $username : ''; ?>" class="form-control">            
        </div>
        <div class="form-group">
            <label>Name</label>
                <input name="name" type="input" value ="<?php echo isset( $_POST[ "name" ] ) ? $name : ''; ?>" class="form-control">            
        </div>
        <div class="form-group">
            <label>Surname</label>
                <input name="surname" type="input" value ="<?php echo isset( $_POST[ "surname" ] ) ? $surname : ''; ?>"class="form-control">            
        </div>
        <div class="form-group">
            <label>Email</label>
                <input type="input" name="email" value ="<?php echo isset( $_POST[ "email" ] ) ? $email : ''; ?>"pattern="^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$" class="form-control"
                    oninvalid="this.setCustomValidity('Come on ..A valid email please')"
                    oninput="this.setCustomValidity('')" />       
        </div>
        <div class="form-group">
            <label>Password</label>
                <input name="password" type="password"  pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,}$" 
                    class="form-control" oninvalid="this.setCustomValidity('Password must be atleast 8 characters must contain at least 1 uppercase letter, 1 lowercase letter, and 1 number')" 
                    oninput="this.setCustomValidity('')" />            
        </div>
        <button id="btn-login" name="Register" class="btn btn-secondary">Register</button>     
    </form><!--Login Form-->
</div>   
    
<?php include "Footer.php" ?>