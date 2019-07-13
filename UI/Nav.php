<?php

//Display correct menu options
function get_page(){
  $tmp = $_SERVER[ 'PHP_SELF' ];
  return ( end( explode( "/", $tmp )) );
}

if ( get_page() === 'Login.php' ) {
  $login = "style = 'display: none'";
  $logout = "style = 'display: none'";
} else if ( get_page() === 'Register.php' ) {
  $sign_up = "style = 'display: none'";
  $logout = "style = 'display: none'";
} else if ( get_page() === 'Welcome.php' ) {
  $sign_up = "style = 'display: none'";
  $login = "style = 'display: none'";
  $welcome = "style = 'display: none'";
}

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
  <a class="navbar-brand" href="Timeline.php">Camagru</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor03">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="Login.php" <?php echo $login; ?>>Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Register.php" <?php echo $sign_up; ?>>Sign Up</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Welcome.php" <?php echo $welcome; ?>>Profile</a>
      </li>
  </div>
<!-- Logout and settings -->

<form class="form-inline my-2 my-lg-0">
  <a class="nav-link" href="#" id="goback"> Back </a>
  <a class="nav-link" href="Logout.php"  <?php echo $logout; ?>> Log Out </a>
</form>
</nav>