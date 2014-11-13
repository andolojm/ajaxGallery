<?php

//Take input argument
$newUrl = $_POST['url'];

//sanitize - only allow jpg uploads behind the http:// protocol
//if(){

  //filter input with OWASP-approved function
  
  
  //insert url
  insertURL($newUrl);
  
  //Success! return to main page
  header('Location: ./index.php');
  
/*
} else {
  header('Location: ./error.php');
}
*/


//Database insertion is done here
function insertURL($url){
  //establish connection
  $mysqli = new mysqli('localhost','root','','gallery');

  //ensure connection
  if($mysqli->connect_errno){
    header('Location: ./error.php');
  } else {
    //if we're connected, prepare and execute the query
    $query = $mysqli->prepare("INSERT INTO url (url) VALUES (?)");

    $query->bind_param("s",$url);
    $query->execute();
  }
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

//XSS prevention - replace dangerous characters
//Function credit - https://www.owasp.org/index.php/OWASP_PHP_Filters
function sanitizeHtmlString($string){
  //characters to look for
  $pattern[0] = '/\&/';
  $pattern[1] = '/</';
  $pattern[2] = "/>/";
  $pattern[3] = '/\n/';
  $pattern[4] = '/"/';
  $pattern[5] = "/'/";
  $pattern[6] = "/%/";
  $pattern[7] = '/\(/';
  $pattern[8] = '/\)/';
  $pattern[9] = '/\+/';
  $pattern[10] = '/-/';
  
  //characters to replace with
  $replacement[0] = '&amp;';
  $replacement[1] = '&lt;';
  $replacement[2] = '&gt;';
  $replacement[3] = '<br>';
  $replacement[4] = '&quot;';
  $replacement[5] = '&#39;';
  $replacement[6] = '&#37;';
  $replacement[7] = '&#40;';
  $replacement[8] = '&#41;';
  $replacement[9] = '&#43;';
  $replacement[10] = '&#45;';
  
  return preg_replace($pattern, $replacement, $string);
}

