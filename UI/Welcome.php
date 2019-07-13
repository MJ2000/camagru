<?php

    //start session
    session_start();
    include_once "Upload.php";

    $username = $_POST[ "username" ];
    $name = $_POST[ "name" ];
    $surname = $_POST[ "surname" ];
    $email = $_POST[ "email" ];
    $password = $_POST[ "password" ];
    $auth = $_POST[ "auth" ];

    //Login section
    if ( isset( $_POST[ 'Login' ]) && isset( $username ) && isset( $password ) ){
        $url = "http://localhost:8080/camagru/api/user/Read.class.php?username=$username";
        $result = file_get_contents( $url );
        $ary = json_decode( $result, true );
        if ( !password_verify( $password , $ary[ 'password' ] )){
            header( "Location: Register.php" );
        } else if ( $ary[ 'auth' ] == 0) {
            echo "Account Not Valid";
            return ;
        } else {
            $_SESSION[ 'id' ] = $ary[ 'id' ];
            $_SESSION[ 'name' ] = $ary[ 'name' ];
            $_SESSION[ 'email' ] = $ary[ 'email' ];
        }
    } else if ( isset( $_POST[ 'Register' ] )){
        $url = "http://localhost:8080/camagru/api/user/Create.class.php";
    } else if ( isset( $_POST[ 'Update' ]) && isset( $username ) && isset( $password ) && isset( $password )){
        $url = "http://127.0.0.1:8080/camagru/api/user/Update.class.php";
        $data = json_encode(array (
                "id"=>$_SESSION[ 'id' ],
                "username"=> $username,
                "email"=> $email,
                "password"=> $password));
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen( $data )));
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );

        $result = curl_exec( $ch );
        if ( $result === FALSE ){
            return( 'not updated' );
        } else {
            curl_close( $ch );
            Header( 'Location: Login.php' );
        }
    }else if( isset( $_SESSION[ 'id' ])){

    }else{        
        header( "Location: Login.php" );
    }
?>

<?php include "Header.php" ?>

    <style>

        .wrapper{
            position: relative;
            margin: auto;
        }
        /* #video{
            object-fit: cover;
            z-index: -1;
            height: 80vh;
            position: absolute;
            } */
        /* #camera{
            height: 80vh;
            position: relative;
        } */
        #filter{
            position: absolute;
            z-index: 1;
            bottom: 1.8rem;
            right: 1.8rem;
            height: 12vh;
            color: white;
            object-fit: contain;
            overflow: hidden;
        }
        .bottom{
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
        }
        .frame-menu{
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: center;
        }

        .frame-menu .frame-item{
            width: 5rem;
            height: 5rem;
            margin: .8rem;
            
        }

        #settings{
            height: 45px;;
        }

        .profile-imgs{
            display: grid;
            grid-template-rows: 1fr 1fr 1fr;
        }
        .gallery{
            width: 20rem;
            margin: 0;
        }
        body{
            padding-bottom: 70px;
        }
    </style>
<body>
    <?php include "Nav.php"; ?>
    <h1 class="display-4 text-center">Welcome <?php echo ( $_SESSION[ 'name' ] ); ?> 
        <img id="settings" src="../assets/gear.svg" alt="settings"></a></h1>

            <!-- Edit profile -->
        <div class="container">
            <form class="jumbotron" method="POST" action="<?php echo $_SERVER[ 'PHP_SELF' ];?>" >
                <div class="form-group">
                    <label>Username</label>
                        <input name="username" type="input" value ="<?php echo isset( $_POST[ "username" ] ) ? $username : ''; ?>" class="form-control">            
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
            <button id="btn-edit" name="Update" class="btn btn-secondary">Update</button>     
            </form><!--Edit Form-->
        </div>   


    <div class="container">
        <section class="row">
            <div id="camera" class="wrapper col-8">
                <div><img id="filter"></div>
                <canvas id="canvas" style="display: none;"></canvas>
                <video class="img-thumbnail" id="video" autoplay ></video>                          
            </div><!--Camera Col-->

            <div class="frame-menu m-auto">        
                <img src="../assets/frames/weird.png" class="pic-frame frame-item rounded" alt="New Image">
                <img src="../assets/frames/cry.png"   class="pic-frame frame-item rounded" alt="New Image">
                <img src="../assets/frames/nerd.png"  class="pic-frame frame-item rounded" alt="New Image">
                <img src="../assets/frames/hair.png"  class="pic-frame frame-item rounded" alt="New Image">
                <img src="../assets/frames/girl.png"  class="pic-frame frame-item rounded" alt="New Image">
            </div><!--Preview Slider-->

            <button id="prnt-scrn" type="capture" name="capture" class="btn btn-secondary btn-lg  btn-block">Capture</button>

            <label for="imgUpload">Upload Image</label>
            <input type="file" name="image" class="form-control-file" id="imgUpload" aria-describedby="fileHelp">
            <input type="submit" id="btn-upload" class="btn btn-primary btn-sm" value="Upload Image" name="upload">
            <small id="fileHelp" class="form-text text-muted">This is where you upload a pic.</small>
            <!--Choose Image-->
                    
        </section><!--Camera Row-->

        <!--Recent edits-->
        <section class="bottom container">
            <?php
                $url = "http://127.0.0.1:8080/camagru/api/Image/Read.class.php";
                $result = file_get_contents( $url );
                $ary = json_decode( $result, true );
                $edits = $ary[ 'data' ];
                $count = 0;
                $lim = 4;
                    while ( $count < sizeof( $edits ) && $lim ){ ?>
                      <?php  if ( $edits[ $count ][ 'user_id' ] == $_SESSION[ 'id' ]){ ?>
                            <?php $lim--; ?>
                            <img class="card-img-top edits" src=" <?php echo $edits[ $count ][ 'location' ] .$edits[ $count ][ 'title' ]; ?> " alt="">
                        <?php  } ?>
                    <?php $count++; ?>
                <?php  } ?>
        </section><!--Recent edits-->
    </div><!--Container-->
    
<script async src="js/capture.js"></script>
<script async src="js/welcome.js"></script>
<?php include "Footer.php" ?>