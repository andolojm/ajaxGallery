<!DOCTYPE html>
<html>
<head>
  <title>Gallery | 1080p Wallpaper Gallery</title>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="style.css" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script type="text/javascript" src="ajaxSlideshow.js"></script>
</head>

<body>
  <div id="header">
    <h1>1080p Wallpaper Gallery</h1>
  </div>
  <div id="slideshow">
    <div id="pic">
      <a href="#" title="Full Size Image">
        <img id="wallpaper" src="ajax-loader.gif" alt="Wallpaper" />
      </a>
    </div>
    <div id="nav">
      <a href="#" onclick="slideshow.getPrevImage()" class="navButton">Previous Image</a>
      <a href="#" onclick="slideshow.deleteImage()" class="delButton">Delete this Image</a>
      <a href="#" onclick="refreshImageListings(slideshow)" class="refreshButton">Refresh Images</a>
      <a href="#" onclick="slideshow.getNextImage()" class="navButton">Next Image</a>
    </div>
    <div id="upload">
      <form action="addUrl.php" method="POST">
        <label for="urlAdd">Don't like any? Add your own by entering the URL:</label>
        <input type="text" name="url" placeholder="Like so: http://google.com/image.jpg" size="35"/>
        <input type="submit" />
      </form>
      <p>We accept .jpg files. Just input the link and it will be added!</p>
    </div>
  </div>
</body>
</html>
