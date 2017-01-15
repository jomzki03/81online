<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link
	rel="stylesheet" type="text/css" href="css/style.css">
<?php 
include("./data/config.inc.php");
require_once("functions.php");
?>
<title>Cerberus VPN Status</title>

<?php

//  To prevent global variables caused by security risks
$admin = false;
session_id($_GET['s']);
session_start();
$sn=session_id();
//  Determine whether logged in or not
if (!(isset($_SESSION["success"]) && $_SESSION["success"] == true)) {
	//  Validation failed with $ _SESSION ["success"] set to false
	$_SESSION["success"] = false;
	echo("<meta http-equiv=refresh content='0; url=login.php'>");
} else {

	$username          =$_SESSION["username"];

	?>

<div align="center">

	<table style="width: 762px; border: 1px solid black;" cellpadding="0"
		cellspacing="0">
		<tr>
			<TH align=left style="height:113px;"><a
				href="index.php?s=<?php echo ''.$sn.''; ?>" title="Home"><IMG style="height:113px; width:auto;"
					src="images/logo.png" alt=""> </a>
			</TH>
		</tr>
	</table>
	<table style="width: 762px;" cellpadding="1" cellspacing="1">
		<tr class="Title_style1" bgcolor="#92ccfd">
			<td width="20%">
				<div align="center">
					<a href="./download.php?s=<?php echo ''.$sn.''; ?>">Openvpn Program Download</a>
				</div>
			</td>

			<td width="20%">
				<div align="center">
					<a href="./doc/vpn-noncert.zip">Openvpn Certificate Download</a>
				</div>
			</td>

			<td width="20%">
				<div align="center">
					<a href="./instruction.php?s=<?php echo ''.$sn.''; ?>"
						target="_blank">Openvpn Instructions</a>
				</div>
			</td>

			<td width="15%">
				<div align="center">
					<a href="change.php?s=<?php echo ''.$sn.''; ?>">Change Password</a>
				</div>
			</td>

			<td width="10%">
				<div align="center">
					<a href="logout.php?s=<?php echo ''.$sn.''; ?>">Log Out</a>
				</div>
			</td>

			<td width="auto">
			</td>
		</tr>
	</table>
</div>
<?php } ?>
