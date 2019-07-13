<?php
//begin guest session
session_start();

include_once "../../obj/Read.class.php";
require "Functions.php";

if (isset($_POST[ 'page'])){
    $page = $_POST[ 'page' ];
} else{
    $page = 0;
}

$url = "http://127.0.0.1:8080/camagru/api/Image/Read.class.php?page=" . $page;
$result = file_get_contents( $url );
$ary = json_decode( $result, true );
$likes = $ary[ 'likes' ];
$comments = $ary[ 'comments' ];

?>

<?php include "Header.php" ?>

<style>
    .post{
        width: 20rem;
    }
    body{
        padding-bottom: 65px;
    }
    .todisplay{
        display: none;
    }

</style>

<!--Main Navigation-->
<?php 
    include "Nav.php";
    $display = 'todisplay';
?>

<?php foreach ( $ary[ 'data' ] as $post){ ?>
    <div class="container">
    <div id="<?php echo $post[ 'id' ]; ?>" class="card border-dark mb-3 post">    
        <div class="card-header delete">
            <button name="remove" type="button" class="btn remove btn-secondary btn-sm <?php if( $post[ 'user_id' ] !== $_SESSION[ 'id' ] ){ echo $display; }?>">Delete</button>
        </div>
        <img class="card-img-top" src=" <?php echo $post[ 'location' ] . $post[ 'title' ]; ?> " alt="">
        <div class="card-header"> On <?php echo $post[ 'created' ]; ?></div><!--created on-->
        <?php  for ( $i = 0; $i < sizeof( $likes ); $i++ ){ ?>
            <?php if ( $likes[ $i ]["img_id"] == $post[ 'id' ]){ ?>
                <aside class="list-group-item d-flex justify-content-between align-items-center">
                    <span  class="<?php if( !isset( $_SESSION[ 'id' ] )){ echo $display; } ?> btn-like btn btn-secondary btn-sm">like</span>
                    <span class="badge badge-primary badge-pill"><?php echo $likes[$i]["tot_likes"];?></span>
                </aside>
            <?php } ?>
        <?php } ?>
       
        <div class="card-body">        
        <?php  for ( $i = 0; $i < sizeof( $comments ); $i++ ){ ?>
            <?php if ( $comments[ $i ]["img_id"] == $post[ 'id' ]){ ?>                
                <p class="card-text"><?php echo $comments[ $i ]["body"] . "\n\n\n";?> </p>               
            <?php } ?>
       <?php } ?>
    </div>

    <div class="comment-block form-group">
      <textarea class="<?php if( !isset( $_SESSION[ 'id' ] )){ echo $display; } ?> txt_comment form-control" placeholder="Write a Comment.." rows="3"></textarea>
      <button type="button" class="<?php if( !isset( $_SESSION[ 'id' ] )){ echo $display; } ?> btn-comment btn btn-secondary btn-sm btn-block"> Send </button>
    </div>
    </div><!--Post Card-->
    </div><!--Main Section-->

<?php } ?>

<!-- Pagination -->
    <ul class="pagination">
    <li class="page-item">
        <a class="page-link" id="prev"> &laquo;</a>
    </li>
    <li class="page-item">
        <a class="page-link" id="next"> &raquo;</a>
    </li>
    </ul>
 <script async src="js/comment.js"></script>
 <script async src="js/timeline.js"></script>
 <script async src="js/like.js"></script>
<?php include "Footer.php" ?>