var serverUrl = "http://jeffandolora.com/CapstoneAJAXLab/getUrls.php";
var deleteUrl = "http://jeffandolora.com/CapstoneAJAXLab/deleteUrl.php";
var ready = false; //changed by refreshImageListings success
var currentImgName;
var slideshow = new SlideShow();
refreshImageListings(slideshow);

function SlideShow(){
  this.currentImg;
  this.maxImages;
  this.imageList;
}

//called from button onClick
SlideShow.prototype.getNextImage = function(){
  if(ready){
    var imgToGet = this.currentImg + 1;
    
    if(imgToGet >= this.maxImages){
      imgToGet = 0;
      this.currentImg = 0;
    } else {
      this.currentImg += 1;
    }
  
    var imgName = this.imageList[imgToGet];
  
    console.log('getting ' + imgName);
  
    this.replaceImage(imgName);
  }
}

SlideShow.prototype.getPrevImage = function(){
  if(ready){
    var imgToGet = this.currentImg - 1;
    
    if(imgToGet < 0){
      imgToGet = this.maxImages - 1;
      this.currentImg = this.maxImages - 1;
    } else {
      this.currentImg -= 1;
    }
    
    var imgName = this.imageList[imgToGet];
    
    console.log('getting ' + imgName);
   
    this.replaceImage(imgName);
  }
}


SlideShow.prototype.replaceImage = function(imgName){
  currentImgName = imgName;
  var newImg = '<a href="' + imgName + '" title="Full Size Image"><img id="wallpaper" src="' + imgName + '" alt="Wallpaper" /></a>';
  $('#pic').html(newImg);
  
}

function refreshImageListings(aSlideShow){
  $.ajax({
    url: serverUrl,
    cache: false,
    success: function(xhr, status){
      var returned = JSON.parse(xhr);
      if(Object.prototype.toString.call(returned) == '[object Array]'){
        aSlideShow.currentImg = -1;
        aSlideShow.imageList = returned;
        aSlideShow.maxImages = returned.length;
        ready = true;
        aSlideShow.getNextImage();
     } else {
        console.log(xhr);
        alert("Server returned unexpected image listing. Cannot load images, try refreshing or coming back later.");
      }
    }, error: function(xhr, status){
	console.log(xhr);
        alert("Server returned unexpected image listing. Cannot load images, try refreshing or coming back later.");
    }});
}

SlideShow.prototype.deleteImage = function(){
  if(window.confirm("Really delete this image?")){
    $.ajax({
      url: deleteUrl,
      data: {url: currentImgName},
      success: function(xhr,status){
        if(xhr == "deleted"){
          alert("Image deleted");
          refreshImageListings(slideshow);
        } else {
          console.log(xhr);
          alert("We couldn't delete that. Please try again, or come back later.");
        }
      }, error: function(xhr, status){ 
        alert("We couldn't delete that. Please try again, or come back later.");
      }});
  }
}
