<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php include_once('header.php'); ?>
<title>Download Openvpn</title>
</head>
<body>
	<?php 
	//  Determine whether logged in or not
	if (!(isset($_SESSION["success"]) && $_SESSION["success"] == true)) {
		//  Validation failed with $ _SESSION ["success"] set to false
		$_SESSION["success"] = false;
		echo("You are not logged in! Redirecting to login page.");
		echo("<meta http-equiv=refresh content='2; url=login.php'>");
		die();
	}
	else {
?>

	<div style="text-align: center;">
		<br> <a href="./doc/openvpn-install-2.3.2-I001-i686.exe">Download for Windows 32-bit (Universal)</a>
		<br>
		<br> <a href="./doc/openvpn-install-2.3.2-I001-x86_64.exe">Download for Windows 64-bit</a>
		<br>
		<br> <a href="./doc/Tunnelblick_3.3beta21b.dmg">Mac Download</a>
	</div>
</body>
<?php } ?>
</html>
