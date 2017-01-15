<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link
	rel="stylesheet" type="text/css" href="../css/style.css">
<?php 
include("../data/config.inc.php");
require_once("admin_functions.php");
?>
<title>Administrator Panel</title>

<?php

//  To prevent global variables caused by security risks
$admin = false;
session_id($_GET['s']);
session_start();
$sn=session_id();
//  Determine whether Logged in or not
if (!(isset($_SESSION["success"]) && $_SESSION["success"] == true)) {
	//  Validation failed with $ _SESSION ["success"] set to false
	$_SESSION["success"] = false;
	echo("<meta http-equiv=refresh content='0; url=login.php'>");
} else {
	$username          =$_SESSION["username"];

	$sql="SELECT admin_level FROM admin WHERE username = '$username' GROUP BY username";

	$result=mysql_query($sql);

	$admin_row=mysql_fetch_row($result);

	?>

<div align="center">

	<table style="width: 762px; border: 1px solid black;" cellpadding="1"
		cellspacing="0">
		<tr>
			<TH align=left height=113><a
				href="index.php?s=<?php echo ''.$sn.''; ?>" title="Home"><IMG height=113
					src="../images/logo.png" alt=""> </a>
			</TH>
		</tr>
	</table>
	<table style="width: 762px;" cellpadding="1" cellspacing="1">
		<tr class="Title_style1" bgcolor="#92ccfd">
			<td width="20%">
				<div align="center">
					<a href="./index.php?s=<?php echo ''.$sn.''; ?>">Home</a>
				</div>
			</td>

			<td width="20%">
				<div align="center">
					<a href=""></a>
				</div>
			</td>

			<td width="20%">
				<div align="center">
					<a href=""
						target="_blank"></a>
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
				<div align="center">
					<?php if($admin_row[0]!=1){ ?>
					<a href="newuser.php?s=<?php echo ''.$sn.''; ?>">Management Interface</a>
					<?php } ?>
				</div>
			</td>
		</tr>
	</table>
</div>
<?php } ?>
