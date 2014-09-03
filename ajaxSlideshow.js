var serverUrl = "http://jeffandolora.com/CapstoneAJAXLab/getUrls.php";
var deleteUrl = "http://jeffandolora.com/CapstoneAJAXLab/deleteUrl.php";
var ready = false; //changed by refreshImageListings success
var currentImgName; //needed for SlideShow.prototype.deleteImage

var slideshow = new SlideShow(); //init the photo gallery
refreshImageListings(slideshow);

//class constructor
function SlideShow() {
    this.currentImg;
    this.maxImages;
    this.imageList;
}

//called from button onClick
SlideShow.prototype.getNextImage = function () {
    if(ready) {
        var imgToGet = this.currentImg + 1; //next image in array

        //go back to the first image if we're currently at the last image
        if(imgToGet >= this.maxImages) {
            imgToGet = 0;
            this.currentImg = 0;
        } else {
            this.currentImg += 1;
        }

        //pull the image name out of the array
        var imgName = this.imageList[imgToGet];

        //replace the HTML
        this.replaceImage(imgName);
    }
};

//called from button onClick
SlideShow.prototype.getPrevImage = function () {
    if(ready) {
        var imgToGet = this.currentImg - 1; //prev image in array

        //go back to the last image if we're currently at the first image
        if (imgToGet < 0) {
            imgToGet = this.maxImages - 1;
            this.currentImg = this.maxImages - 1;
        } else {
            this.currentImg -= 1;
        }

        //pull the image name out of the array
        var imgName = this.imageList[imgToGet];

        //replace the HTML
        this.replaceImage(imgName);
    }
};


//replaces HTML in index.php
//
SlideShow.prototype.replaceImage = function (imgName) {
    currentImgName = imgName; //we need this for SlideShow.prototype.deleteImage, and this is a handy way to set it

    var newImg = '<a href="' + imgName + '" title="Full Size Image"><img id="wallpaper" src="' + imgName + '" alt="Wallpaper" /></a>';
    $('#pic').html(newImg);

};

function refreshImageListings(aSlideShow) {

    //send request for a new image list
    $.ajax({
        url: serverUrl,
        cache: false, //ensure we get the absolute newest list
        success: function (xhr, status) { //runs on 200 status

            //we're expecting an array, so only continue if we get that
            var returned = JSON.parse(xhr);
            if (Object.prototype.toString.call(returned) == '[object Array]') {

                //reset slideshow
                aSlideShow.currentImg = -1;

                //set slideshow's images based on returned array
                aSlideShow.imageList = returned;
                aSlideShow.maxImages = returned.length;

                //tell the slideshow that the above process is done
                ready = true;
                aSlideShow.getNextImage();

            } else {
                //we didn't get an array
                console.log(xhr);
                alert("Server returned unexpected image listing. Cannot load images, try refreshing or coming back later.");
            }
        }, error: function (xhr, status) {
            //we didn't get anything
            console.log(xhr);
            alert("Server returned unexpected image listing. Cannot load images, try refreshing or coming back later.");
        }});
}

SlideShow.prototype.deleteImage = function () {
    //ensure that the user actually meant to do this
    if (window.confirm("Really delete this image?")) {

        //send the request
        $.ajax({
            url: deleteUrl,
            data: {url: currentImgName}, //tack a variable to the get request
            success: function (xhr, status) { //runs on 200 status

                //success returns "deleted"
                if (xhr == "deleted") {
                    alert("Image deleted");
                    refreshImageListings(slideshow);
                } else { //error returns "error"
                    console.log(xhr);
                    alert("We couldn't delete that. Please try again, or come back later.");
                }
            }, error: function (xhr, status) {
                alert("We couldn't delete that. Please try again, or come back later.");
            }});
    }
};
