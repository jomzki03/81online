<!doctype html>
<html>
<head>
<?php include_once('header.php'); ?>
<title>Cerberus VPN Service Instructions</title>
</head>
<body>
	<?php 
	//  Determine whether logged in  or not
	if (!(isset($_SESSION["success"]) && $_SESSION["success"] == true)) {
		//  Validation failed with $ _SESSION ["success"] set to false
		$_SESSION["success"] = false;
		echo("You are not logged in! Redirecting to login page.");
		echo("<meta http-equiv=refresh content='2; url=login.php'>");
		die();
	}
	else {
?>


<body>
	Windows
<br>
1. Click the openvpn program to download
	<br> *Select the appropriate version, and perform the installation. 
	<br>*32-bit version of Windows can run on 32 and 64-bit operating system, if you do not know what system, you can directly download 32-bit.
<br>2. Click the openvpn certificate file to download vpn-noncert.zip
<br>3. Open the OPENVPN installation folder, the default is C: / Program Files (X86) / OpenVPN / config, unzip all the files in vpn-config.zip directly into this folder. Config folder is also available in the Start menu - Programs - OpenVPN - Shortcuts - OpenVPN Configuration file directory found.
4. Then extract the certificate file to find passwd.txt, open it and your username and your password. Change your username and password to save.
<br>
5. Openvpn in the Start menu to find this program, right-run with administrator privileges OPENVPN, in the lower right corner there will be a small icon, right-point connect, wait for the small icon turns green is successful. Each initial flow 10G, more than the flow will be unable to connect, do not have time to manually disconnect.
<br>
<br>
<br> Mac Edition
<br>
1. Click the openvpn program to download, select the Mac version, and perform the installation.
<br>2. Click the openvpn certificate file to download vpn-noncert.zip
<br>3. Run TunnelBlick
<br>4. Will be prompted to add a setting, click I have settings file, then click OpenVPN settings, and then click to open the private settings folder.
<br> 5. will just download the contents of the second part of the compressed package to extract the private settings folder.
<br>6. Then extract the certificate file to find passwd.txt, open it and your username and your password
	<br>*Change your username and password to save. The user name and password have one line, with no spaces in each line.
<br>7. In the upper right corner to find a small tunnel icon, right-click connect (connection), the specific name may be different.
<br>8. Connection can be used after the success. Each initial flow 10G, more than the flow will be unable to connect. Do not need to manually disconnect the time, right-click on the small tunnel to disconnect.
</body>
<?php } ?>
</html>
