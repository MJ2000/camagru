window.addEventListener( "load", ft_open, false );
const capt = document.querySelector( "#prnt-scrn" );
const vid = document.querySelector( "#video" );
const canvas = document.querySelector( "#canvas" );
const photoo = document.querySelector( "#photoo" );
const camera_pix = document.querySelector( "#camera-image" );
const btn_upload = document.querySelector( "#btn-upload" );
const edits = document.querySelector( ".edits" );

const filter = document.querySelector("#filter");
const frame = document.querySelectorAll( '.pic-frame' );
const upload = document.querySelector( '#imgUpload' );

var new_images = [];

var xhr;
var snap;
xhr = new XMLHttpRequest();
 
function ft_open(){
    //ES6 promises
    navigator.mediaDevices.getUserMedia({
        audio: false,
        video: true
    }).then( stream => {
        video.srcObject = stream;
    }).catch( console.error )
}

// hide video canvas
upload.onchange = function(){
    vid.style.display = "none";
    capt.style.display = "none";
    canvas.style.display = "inline-block";
    
    var pic = new Image();
        
    pic.onload = function() {
        canvas.width = this.width;
        canvas.height = this.height;
        canvas.getContext('2d').drawImage( this, 0, 0 );
    }
    pic.onerror = function(){
        console.error("Error Occured");
    }
    pic.src = URL.createObjectURL( this.files[ 0 ]);
}

//load filter
frame.forEach( function( item ){    
    item.onclick = function(){
        filter.src = item.src;
    }
});

//sending the frame image
btn_upload.onclick = function(){  
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            snap =  canvas.toDataURL( "image/png" );
            user_images();
            location.reload();
      }
    };
    xhr.open( "POST", "Upload.php" );
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send( "img=" + snap + "&filter=" + filter.src );
}

capt.onclick = function() {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage( video, 0, 0 );

    //AJAX for sending Img to Server
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            snap =  canvas.toDataURL( "image/png" );
            if( user_images()){
            }
      }
    };
    xhr.open( "POST", "Upload.php" );
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send( "img=" + snap + "&filter=" + filter.src );
};


//render images
function user_images(){
    var elem = document.createElement("img");
    elem.classList.add( 'rounded' );
    elem.classList.add( 'preview' );
    elem.setAttribute('alt', 'new image');
    elem.src = snap;
    //add images
    
    if ( new_images.length >= 3 ){
        //remove first elem
        new_images.shift();
    }
    new_images.push( elem );
    camera_pix.appendChild( elem );
}