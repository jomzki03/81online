<?php
include("../data/config.inc.php");
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
else if(isset($_POST['new_user'])){
	session_id($_GET['s']);
	session_start();
	//echo $_SESSION["username"];
	$active = mysql_real_escape_string($posts["active"]);
	$name = mysql_real_escape_string($posts["name"]);
	$email = mysql_real_escape_string($posts["email"]);
	$cycle = mysql_real_escape_string($posts["cycle"]);
	$quota_bytes = mysql_real_escape_string($posts["quota_bytes"])*1024*1024*1024;
	$enable = mysql_real_escape_string($posts["enable"]);
	$level = mysql_real_escape_string($posts["level"]);
	$admin_level = mysql_real_escape_string($posts["admin_level"]);
	echo new_user(mysql_real_escape_string($posts["username"]),mysql_real_escape_string($posts["password"]),mysql_real_escape_string($posts["repassword"]),$active,$name,$email,$cycle,$quota_bytes,$enable,$level,$admin_level);
}
else if(isset($_POST['del_user'])){
	session_id($_GET['s']);
	session_start();
	//echo $_SESSION["username"];
	echo del_user($_SESSION["username"],mysql_real_escape_string($posts["username"]),mysql_real_escape_string($posts["password"]),mysql_real_escape_string($posts["admin_level"]));
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
 * This is the function used to log in。
 * After the user logs in, it checks whether the user name and password are correct。
 * If correct, it will give a session id, lifeTime will be over after failure。
 */
function checklogin($username,$password){
	$sql = "SELECT * FROM admin WHERE password = password('$password') AND username = '$username'";
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
		echo("Wrong Username or Password!");
		//echo("<meta http-equiv=refresh content='3; url=login.php'>");
	}
}

/**
 * Change Password
 * With the old password to verify, and then check the new password and repeat the new password is the same
 */
function pwchange($username,$oldpassword,$newpassword,$renewpassword){
	$sql = "SELECT * FROM admin WHERE password = password('$oldpassword') AND username = '$username'";
	$result = mysql_query($sql) or die ("wrong");
	$userInfo = mysql_fetch_array($result);

	if($newpassword != $renewpassword){
		echo('You must enter the same password twice in order to confirm it! Password should be between 6-20 digits..');
		//echo("<meta http-equiv=refresh content='2; url=change.php'>");
	}else{
		//If the password is correct, there will be a row to return the results
		if(mysql_num_rows(mysql_query($sql))==1 ){
			$sql="Update admin set password=password('$newpassword') where username='$username'";
			mysql_query($sql) or die(mysql_error());
			echo('Password changed successfully!');
			echo("<meta http-equiv=refresh content='2; url=login.php'>");
		}else{
			echo('Your password was incorrect.');
			//echo("<meta http-equiv=refresh content='2; url=change.php?s='.$sn.''>");
		}
	}
}

/**
 * Add a new user
 * Add the appropriate column information to the database
 * Here you can try to send an array in the future, in order to add additional information.
 */
function new_user($username,$password,$repassword,$active,$name,$email,$cycle,$quota_bytes,$enable,$level,$admin_level){
	session_id($_GET['s']);
	session_start();
	$sn = session_id();
	if( $password != $repassword){
		echo('You must enter the same password twice in order to confirm it! Password should be between 6-20 digits.');
	}else{
		$table=user;
		if($admin_level==1){
			$sql="INSERT INTO `admin` (`id`,`username`, `password`,  `email`, `admin_level`)
			VALUES (NULL,'$username', PASSWORD('$password'), '$email', '$level')";
			mysql_query($sql) or die(mysql_error());
		}
		else{
			$sql="INSERT INTO `user` (`username`, `password`, `active`, `creation`, `name`, `email`, `note`, `level`, `quota_cycle`, `quota_bytes`, `used_quota`, `left_quota`, `enabled`) VALUES ('$username', PASSWORD('$password'), '$active', CURRENT_TIMESTAMP, '$name', '$email', NULL,'$level','$cycle', '$quota_bytes', '0', '$quota_bytes', '$enable')";
			$sql1="INSERT INTO `stat` (`total_used`,`username`, `origin_time`) VALUES ('0','$username', CURRENT_TIMESTAMP)";
			mysql_query($sql) or die(mysql_error());
			mysql_query($sql1) or die(mysql_error());
		}
		echo("User ".$username." added successfuly! "." Password ".$password);
		//echo("<meta http-equiv=refresh content='2; url=index.php?s=".$sn."'>");

	}
}

	/**
	 * Delete user
	 * With the administrator user name and enter the password to detect whether the administrator, so you can avoid accidentally deleted
	 * Then correct, then directly delete the input user name
	 * Need to add: delete the deleted user name
	 */
	function del_user($admin_username,$username,$password,$admin_level){
		session_id($_GET['s']);
		session_start();
		$sn = session_id();
		$sql = "SELECT * FROM `admin` WHERE `password` = password('$password') AND `username` = '$admin_username'";
		//  Get the query results
		$result = mysql_query($sql) or die("wrong");
		$userInfo = mysql_fetch_array($result);
		if(!empty($userInfo)){
			if($admin_level==1){
				$sql1 = "DELETE FROM `admin` WHERE `username`='$username'";
				mysql_query($sql1) or die(mysql_error());
			}
			else{
				$sql1="DELETE FROM `user` WHERE `username`='$username'";
				$sql2="DELETE FROM `stat` WHERE `username`='$username'";
				mysql_query($sql1) or die(mysql_error());
				mysql_query($sql2) or die(mysql_error());
			}
			echo('User'.$username.'successfully deleted!');
			//echo("<meta http-equiv=refresh content='2; url=index.php?s=".$sn."'>");
		}
		else{
			echo("Wrong password! Return to the previous page");
			//echo("<meta http-equiv=refresh content='2; url=deluser.php?s=".$sn."'>");
		}
	}

	?>
