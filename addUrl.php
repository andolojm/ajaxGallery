<?php

//Take input argument
$newUrl = $_POST['url'];

//sanitize - only allow jpg uploads behind the http:// protocol
if(beginsWith($newUrl,"http://") && endsWith($newUrl,'.jpg')){

    //insert url if sanitization test passes
    insertURL($newUrl);

    //Success! return to main page
    header('Location: ./index.php');
} else {
    header('Location: ./error.php');
}

//sanitization functions
//clean and reusable much unlike a heroin needle
function endsWith($string,$test){
    //get lengths
    $strLen = strlen($string);
    $testLen = strlen($test);

    //ensure test is not longer than string
    if($testLen > $strLen){
          //string can't end with test if test is longer than string!
          return false;
    }
    //substr_compare automatically compares test with the end of the string
     return substr_compare($string, $test, $strLen - $testLen, $testLen) === 0;
}

function beginsWith($string, $test){

    //this one's a bit simpler because we can just start at $string[0]
    //don't have to compute lengths
    return strpos($string, $test) === 0;
}

//Database insertion is done here
function insertURL($url){
    //establish connection
    $mysqli = new mysqli('localhost','root','rootsql','Gallery');

    //ensure connection
    if($mysqli->connect_errno){
        header('Location: ./error.php');
    } else {
        //if we're connected, prepare and execute the query
        $query = $mysqli->prepare("INSERT INTO Url (url) VALUES (?)");

        $query->bind_param("s",$url);
        $query->execute();
    }
}
