<?php

$urlToDelete = $_GET['url'];

//delete the url from the database
deleteUrl($urlToDelete);

//this page is called by ajax, so we'll return 'deleted' instead of redirecting
echo "deleted";

//Database deletion is done here
function deleteURL($url){
    //establish connection
    $mysqli = new mysqli('localhost','root','','gallery');

    //ensure connection
    if($mysqli->connect_errno){
        header('Location: ./error.php');
    } else {
        //if we're connected, prepare and execute the query
        $query = $mysqli->prepare("DELETE FROM url WHERE url = ?");

        $query->bind_param("s",$url);
        $query->execute();
    }
}

