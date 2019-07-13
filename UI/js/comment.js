const txt_comment = document.querySelector( ".txt_comment" );
var card = document.querySelectorAll( '.comment-block' );
var xhr;

xhr = new XMLHttpRequest();

//Send Email Ajax
function send_email( tmp ){

  //Sending ID to Timeline
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    }
  };
  xhr.open( "POST", "Functions.php" );
  xhr.setRequestHeader( "Content-type", "application/json; charset=utf-8" );
  if ( xhr.send( "id=" + tmp )){
    console.log("Email sent");
  }
}

card.forEach( function( item  ){
  var text = item.childNodes[ 1 ];
  var btn = item.childNodes[ 3 ];

  btn.onclick = function(){
    var comment = text.value;
    var id = item.parentNode.id;
    var one_like = { "img_id" : id , "body" : comment };
    text.value = '';

    var user = ( this.parentNode.parentElement.children[1].src ).split( '_');
    let tmp = user[0].split('/').pop();
    if ( tmp ){
      send_email( tmp );
    } else{
      console.log( "not called");
    }

    //AJAX for sending like to Server
    xhr.open( "POST", "../api/image/Create.class.php" );
    xhr.setRequestHeader( "Content-type", "application/json; charset=utf-8" );
    xhr.send( JSON.stringify( one_like ));
  }
});