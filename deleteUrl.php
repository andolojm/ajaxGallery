<?php

$urlToDelete = $_GET['url'];

//sanitize (hmm, wonder where we've seen those functions before. addUrl.php, before you start searching)
if(beginsWith($urlToDelete,"http") && endsWith($urlToDelete,".jpg")){

    //if sanitized, delete the url from the database
    deleteUrl($urlToDelete);

    //this page is called by ajax, so we'll return 'deleted' instead of redirecting
    echo "deleted";
} else {
    //This page is called by ajax, so we'll return 'error' instead of redirecting
    echo "error";
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

//Database deletion is done here
function deleteURL($url){
    //establish connection
    $mysqli = new mysqli('localhost','root','rootsql','Gallery');

    //ensure connection
    if($mysqli->connect_errno){
        header('Location: ./error.php');
    } else {
        //if we're connected, prepare and execute the query
        $query = $mysqli->prepare("DELETE FROM Url WHERE url = ?");

        $query->bind_param("s",$url);
        $query->execute();
    }
}

