<?php
    
    include "Nav.php";
    require "Functions.php";

    if( filter_has_var( INPUT_POST, "Login" )){
        //Get Form Data
        $username = $_POST[ "username" ];
        $password = $_POST[ "password" ];
    }
   
    if ( isset( $_POST[ 'reset' ]) ){
        //send temp password
        $email = $_POST[ 'email' ];
        $tmp = "HelloWorld911";
        $to = $email;
        $subject = "New Password: ";
        $message = "Here is your new password" . $tmp . "\r\n";
        $headers =  "MIME-VERSION : 1.0" . "\r\n";
        $headers .= "CONTENT-TYPE : text/html; charset = UTF-8 " . "\r\n";
        $headers .= "From : alathantonga@gmail.com" . "\r\n";
        $headers .= "Reply-To : no-reply" . "\r\n";
        if (!( mail ($to, $subject, $message, $headers ))){
            echo "Email Not sent";
        } else {
            if ( new_password( $email )){
                echo "Check your email";
            }
        }
        curl_close( $ch );
    }
?>

<?php include "Header.php" ?>
<div class="container">

    <div class="jumbotron">
        <form  action="Welcome.php" method="POST">
            <div class="form-group">
                <label>Username</label>
                    <input type="input" name="username" title="username" value ="<?php echo isset( $_POST[ "username" ] ) ? $username : ''; ?>" class="form-control">            
            </div>
            <div class="form-group">
                <label>Password</label>
                    <input pattern=".{2,}" name="password" title="Six or more characters" type="password" class="form-control">            
            </div>
            <button id="btn-login" name="Login" class="btn btn-secondary">Login</button>     
        </form><!--Login Form-->
        <button id="btn-reset" class="btn btn-secondary">Reset Password</button>
    </div>


    <div id="forgot-password" style="display: none">
        <div class="jumbotron">
        <form method="POST" action="<?php echo $_SERVER[ 'PHP_SELF' ] ?>" >
        <div class="form-group">
            <label>Email address</label>
            <input type="email" name='email' id="txt-email" class="form-control" placeholder="Enter email">
            <small class="form-text text-muted">be sure you forgot your email, i mean pw.</small>
        </div>        
        <button type="submit" name="reset" class="btn btn-outline-secondary">Reset</button>
        </form>
        </div>
    </div>
</div>
<script src="js/login.js"></script>
<?php include "Footer.php" ?>