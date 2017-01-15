<?php
include("./data/config.inc.php");
//After the form is submitted...
$posts = $_POST;
//Clear some blank symbols
foreach ($posts as $key => $value) {
    $posts[$key] = trim($value);
}

echo($db_host+$db_user+$db_pass);

mysql_connect($db_host,$db_user,$db_pass) //Fill in the mysql user name and password
   or die("abc"+mysql_error());    

mysql_select_db($db_name) or die("bcd"+mysql_error()); 

mysql_query('set names "gbk"'); //Encoding of data in the database  
$password =  mysql_real_escape_string($posts["password"]);
$username = mysql_real_escape_string($posts["username"]); 
$sql = "SELECT * FROM user WHERE password = password('$password') AND username = '$username'";
//  Get the query results
$result = mysql_query($sql) or die ("wrong"); 
$userInfo = mysql_fetch_array($result); 

if (!empty($userInfo)) {

if ($userInfo["username"] == $username) { 
    //  Set up a storage directory
    $savePath = '../ss_save_dir/';
    //  Save the day
    $lifeTime = 24 * 3600;
    //  Get the current Session name, the default is PHPSESSID
    $sessionName = session_name();
    //  Obtain Session ID
    $sessionID = $_GET[$sessionName];
    //  Use session_id () to set the session ID obtained
    session_id($sessionID); 
    session_set_cookie_params($lifeTime);
    //  When the authentication is passed, the session is started
    session_start();
    //  Register the successful login admin variable and assign true
    $_SESSION["admin"] = true;
    $_SESSION["username"] = $username;
    $sn = session_id();
        echo("<meta http-equiv=refresh content='0; url=index.php?s=".$sn."'>"); 
} else { 
echo("Username or password error code 2! 5 seconds after returning to login page."); 

echo("<meta http-equiv=refresh content='5; url=login.php'>");

} 

} else {
    echo("Username or password error code 1! 5 seconds after returning to login page.");

    echo("<meta http-equiv=refresh content='5; url=login.php'>");

}
?>
