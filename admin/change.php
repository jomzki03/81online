<!doctype html>
<html>
<head>
<?php include_once('header.php'); ?>
<title>Admininstrator Panel</title>
</head>
<body>
	<?php 

	//  Determine whether or not landing
	if (!(isset($_SESSION["success"]) && $_SESSION["success"] === true)) {
		//  Validation failed with $ _SESSION ["success"] set to false
		$_SESSION["success"] = false;
		echo("You are not logged-in! Redirecting to login page");
		echo("<meta http-equiv=refresh content='2; url=login.php'>");
		die();
	}
	else {

?>
	<FORM ACTION="" METHOD="POST">
		<TABLE cellSpacing=0 cellPadding=0 width=268 align=center
			bgColor=#ffff99>
			<TBODY>
				<TR>
					<TD align=center height=25>Old Password：&nbsp; <INPUT tabIndex=1
						type=password maxLength=20 size=15 name=oldpassword>
					</TD>
				</TR>
				<TR>
					<TD align=center>New Password：&nbsp; <INPUT tabIndex=2 type=password
						maxLength=20 size=15 name=newpassword>
					</TD>
				</TR>
				<TR>
					<TD align=center>Retype New Password: &nbsp; <INPUT tabIndex=3 type=password
						maxLength=20 size=15 name=renewpassword>
					</TD>
				</TR>
				<TR>
					<TD align=center height=25><INPUT id=pw_manager
						style="BORDER-RIGHT: 0px; BORDER-TOP: 0px; BORDER-LEFT: 0px; WIDTH: 65px; CURSOR: hand; BORDER-BOTTOM: 0px; HEIGHT: 18px"
						type=submit value="Change Password" name=pw_manager> <INPUT id=reset
						style="BORDER-RIGHT: 0px; BORDER-TOP: 0px; BORDER-LEFT: 0px; WIDTH: 52px; CURSOR: hand; BORDER-BOTTOM: 0px; HEIGHT: 18px"
						type=reset value="Reset" name=reset>
					</TD>
				</TR>

			</TBODY>
		</TABLE>
	</FORM>

	<?php
	}
	?>
</body>
</html>
