<?php
include("./data/config.inc.php");
//  To prevent global variables caused by security risks
$admin = false;
session_id($_GET['s']);
session_start();
//  Determine whether logged in or not
if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
    echo "";
} else {
    //  Validation failed with $ _SESSION ["admin"] set to false
    $_SESSION["admin"] = false;
    echo("You are not logged in! Redirecting to login page");
    echo("<meta http-equiv=refresh content='2; url=login.php'>");
    die();
}

function check_input($value){
// Stripslashes
if (get_magic_quotes_gpc())  {  $value = stripslashes($value);  }
// Quote if not a number
if (!is_numeric($value))  {  $value = "'" . mysql_real_escape_string($value) . "'";  }
return $value;}

// After the form submission ...
$posts = $_POST;
//  Clear some blank symbols
foreach ($posts as $key => $value) {
    $posts[$key] = trim($value);
}
$username          =$_SESSION["username"];
mysql_connect($db_host,$db_user,$db_pass) //Fill in the mysql user name and password  
   or die("Could not connect to MySQL server!");  
mysql_select_db($db_name) //The database name  
   or die("Could not select database!");  
mysql_query('set names "gbk"'); //Encoding of data in the database
$oldpassword =  mysql_real_escape_string($posts["oldpassword"]);
$newpassword =  mysql_real_escape_string($posts["newpassword"]); 
$renewpassword =  mysql_real_escape_string($posts["renewpassword"]);
$sql = "SELECT * FROM user WHERE password = password('$oldpassword') AND username = '$username'";
$result = mysql_query($sql) or die ("wrong"); 
$userInfo = mysql_fetch_array($result); 

  if( $newpassword != $renewpassword){
    echo('New password did not matched! Password should contain at least 6-20 digits.');
    echo("<meta http-equiv=refresh content='2; url=change.php'>");
  }else{   
   if(mysql_num_rows( mysql_query($sql) )==1 ){
    $sql="Update user set password=password('$newpassword') where username='$username'";
    mysql_query($sql) or die(mysql_error());
    echo('Password changed successfully! Redirecting to login page.');
    echo("<meta http-equiv=refresh content='2; url=login.php'>");
   }else{
    echo('Old password was incorrect!');
    echo("<meta http-equiv=refresh content='2; url=change.php'>");
   }
  }

 
?>
