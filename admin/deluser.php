<!doctype html>
<html>
<head>
<?php include_once('header.php'); ?>
</head>
<body>
	<?php 
	//  Determine whether Logged in or not 
	if (!(isset($_SESSION["success"]) && $_SESSION["success"] == true)) {
		//  Validation failed with $ _SESSION ["success"] set to false
		$_SESSION["success"] = false;
		echo("You are not logged in! Redirecting to login page.");
		echo("<meta http-equiv=refresh content='2; url=login.php'>");
		die();
	}
	else if($admin_row[0]!=3){					//Determine whether the administrator 3
		echo("You do not have permission! Returning to previous page.");
		echo("<meta http-equiv=refresh content='0; url=index.php?s=".$sn."'>");
	}
	else {
?>
	<div align="center">
		<div style="width: 762px; border: 1px solid balck;" cellpadding="1"
			cellspacing="0">
			<table style="width: 762px; height: 30px; margin: 10px 0;"
				cellpadding="1" cellspacing="1">
				<tr class="Title_style2" style="background-color: #92ccfd;">

					<td width="10%">
						<div align="center">
							<a href="index.php?s=<?php echo ''.$sn.''; ?>">Home</a>
						</div>
					</td>
					<td width="20%">
						<div align="center">
							<?php if($admin_row[0]!=1){ ?>
							<a href="newuser.php?s=<?php echo ''.$sn.''; ?>">Add User</a>
							<?php } ?>
						</div>
					</td>

					<td width="20%">
						<div align="center">
							<?php if($admin_row[0]==3){ ?>
							<a href="deluser.php?s=<?php echo ''.$sn.''; ?>">Delete User</a>
							<?php } ?>
						</div>
					</td>

					<td width="20%">
						<div align="center">
							<?php if($admin_row[0]!=1){ ?>
							<a href="admin_list.php?s=<?php echo ''.$sn.''; ?>">Administrator List</a>
							<?php } ?>
						</div>
					</td>

					<td width="20%">
						<div align="center">
							<a href=""></a>
						</div>
					</td>

					<td width="10%">
						<div align="center">
							<a href="logout.php?s=<?php echo ''.$sn.''; ?>">Log Out</a>
						</div>
					</td>
				</tr>
			</table>

			<FORM ACTION="" METHOD="POST">
				<TABLE cellSpacing=0 cellPadding=0 width=350 align=center
					bgColor=#ffff99 border=0>
					<TBODY>
						<TR>
							<TD align=right height=25>Username: &nbsp; <INPUT tabIndex=1 type=text
								maxLength=20 size=20 name=username>
							</TD>
						</TR>
						<TR>
							<TD align=right>Password: &nbsp; <INPUT tabIndex=2 type=password
								maxLength=20 size=20 name=password>
							</TD>
						</TR>
						<TR>
							<TD align=right>Administrator Level: &nbsp; <INPUT tabIndex=2 type=text
								maxLength=20 size=20 name=admin_level value=0>
							</TD>
						</TR>
						<TR>
							<TD align=middle height=25><INPUT id=del_user
								style="BORDER-RIGHT: 0px; BORDER-TOP: 0px; BORDER-LEFT: 0px; WIDTH: 65px; CURSOR: hand; BORDER-BOTTOM: 0px; HEIGHT: 18px"
								type=submit value="Delete User" name=del_user> <INPUT id=reset
								style="BORDER-RIGHT: 0px; BORDER-TOP: 0px; BORDER-LEFT: 0px; WIDTH: 52px; CURSOR: hand; BORDER-BOTTOM: 0px; HEIGHT: 18px"
								type=reset value="Reset" name=reset>
							</TD>
						</TR>

					</TBODY>
				</TABLE>
			</FORM>
		</div>
	</div>
	<?php
	}
	?>
</body>
</html>
