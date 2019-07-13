<?php
  session_start();
  if( session_destroy() ){
    Header( 'Location: Timeline.php' );
  }
  
?>