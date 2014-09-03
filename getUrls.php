<?php

$imgs = array(); //empty array to be filled by getImages

//get urls from db
getImages($imgs);

//format url array into js array notation
$returnJSON = json_encode($imgs);

//output
echo $returnJSON;

function getImages(&$array){
    //establish connection
    $mysqli = new mysqli('localhost','root','rootsql','Gallery');

    //ensure connection
    if($mysqli->connect_errno){
        header('Location: ./error.php');
    } else {
        //if we're connected, prepare and execute the query
        $query = $mysqli->prepare("SELECT url FROM Url");

        $query->execute();

        //bind query returns to variables
        $query->bind_result($url);

        while($query->fetch()){
            $array[] = $url;
        }
    }
}
