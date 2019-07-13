
//rendering likes section with js
const picture = document.querySelectorAll( '.card' );

//create An aside
var like_aside = document.createElement( 'aside' );
like_aside.classList.add( "list-group-item", "d-flex", "justify-content-between", "align-items-center" );

var like_badge = document.createElement( "span" );
like_badge.classList.add( "badge", "badge-primary", "badge-pill" );

var btn_like = document.createElement( 'span' );
btn_like.classList.add( "btn", "btn-like", "btn-secondary", "btn-sm" );
btn_like.innerHTML = "like";


like_aside.append(  btn_like, like_badge );

//render html
for (var i = 0; i < picture.length; i++){
  if (picture[i].querySelector('aside') === null){
    picture[i].insertBefore( like_aside.cloneNode( true ), picture[i].children[2]  );
  }
}

var likes = document.querySelectorAll( 'aside' );

var xhr;

//xhr for ajax
xhr = new XMLHttpRequest();

likes.forEach( function( item ){

  var btn_like = item.querySelector( '.btn' );
  
  btn_like.onclick = function(){
    var id = item.parentNode.id;
    var one_like = { "img_id" : id , "likes_count" : 1 };

    //AJAX for sending like to Server
    xhr.open( "POST", "../api/image/Create.class.php" );
    xhr.setRequestHeader( "Content-type", "application/json; charset=utf-8" );
    xhr.send( JSON.stringify( one_like ));
  }
});