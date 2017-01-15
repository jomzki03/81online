<?php
include("./data/config.inc.php");
//After the form submission ...
$posts = $_POST;
//Clear some blank symbols
foreach ($posts as $key => $value) {
	$posts[$key] = trim($value);
}


mysql_connect($db_host,$db_user,$db_pass) or die(mysql_error()); //Fill in the mysql user name and password

mysql_select_db($db_name)or die(mysql_error());

if(isset($_POST['login'])){
	echo checklogin(mysql_real_escape_string($posts["username"]),mysql_real_escape_string($posts["password"]));
}
else if(isset($_POST['pw_manager'])){
	session_id($_GET['s']);
	session_start();
	echo $_SESSION["username"];
	echo pwchange(mysql_real_escape_string($_SESSION["username"]),mysql_real_escape_string($posts["oldpassword"]),mysql_real_escape_string($posts["newpassword"]),mysql_real_escape_string($posts["renewpassword"]));
}

/**
 * This is used to detect whether content entered by the front-end user contains insecurity, filters, and prevents database injection
 */
function check_input($value){
	// Stripslashes
	if (get_magic_quotes_gpc())  {
		$value = stripslashes($value);
	}
	// Quote if not a number
	if (!is_numeric($value))  {
		$value = "'" . mysql_real_escape_string($value) . "'";
	}
	return $value;
}

/**
 * This is the function used to login.
  * After the user logs in, it checks whether the user name and password are correct.
  * If correct, to assign a session id, lifeTime will be over after failure.
 */
function checklogin($username,$password){
	$sql = "SELECT * FROM user WHERE password = password('$password') AND username = '$username'";
	//  Get the query results
	$result = mysql_query($sql) or die ("wrong");
	$userInfo = mysql_fetch_array($result);
	if (!empty($userInfo)) {
		if ($userInfo["username"] == $username) {
			//  Set up a storage directory
			$savePath = '../ss_save_dir/';
			//  Save half an hour 3600 is an hour
			$lifeTime = 0.5 * 3600;
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
			$_SESSION["success"] = true;
			$_SESSION["username"] = $username;
			$sn = session_id();
			echo("<meta http-equiv=refresh content='0; url=index.php?s=".$sn."'>");
		}
	} else {
		echo("Wrong username or password!");
		//echo("<meta http-equiv=refresh content='3; url=login.php'>");
	}
}



/**
* change Password
  * Use the old password to verify, and then check the new password and repeat the new password is the same
 */
function pwchange($username,$oldpassword,$newpassword,$renewpassword){
	$sql = "SELECT * FROM user WHERE password = password('$oldpassword') AND username = '$username'";
	$result = mysql_query($sql) or die ("wrong");
	$userInfo = mysql_fetch_array($result);

	if($newpassword != $renewpassword){
		echo('New password did not match! Password should contain at least 6-20 digits.');
		//echo("<meta http-equiv=refresh content='2; url=change.php'>");
	}else{
		//If the password is correct, there will be a row to return the results
		if(mysql_num_rows(mysql_query($sql))==1 ){
			$sql="Update user set password=password('$newpassword') where username='$username'";
			mysql_query($sql) or die(mysql_error());
			echo('Password changed successfully! Redirecting to the login page.');
			echo("<meta http-equiv=refresh content='2; url=login.php'>");
		}else{
			echo('Old password is incorrect!');
			//echo("<meta http-equiv=refresh content='2; url=change.php?s='.$sn.''>");
		}
	}
}
?>
