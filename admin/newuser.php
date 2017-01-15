<!DOCTYPE html>
<html>
<head>
<?php include_once('header.php'); ?>
</head>
<body>
	<?php 
	//  Determine whether logged in or not
	if (!(isset($_SESSION["success"]) && $_SESSION["success"] == true)) {
		// Validation failed with $ _SESSION ["success"] set to false
		$_SESSION["success"] = false;
		echo("You are not logged in! Redirecting to login page.");
		echo("<meta http-equiv=refresh content='2; url=login.php'>");
		die();
	}
	else if($admin_row[0]==1){
		echo("You do not have permission! Returning to home page.");
		echo("<meta http-equiv=refresh content='0; url=index.php?s=".$sn."'>");
	}
	else {
    ?>
	<div align="center">
		<div
			style="width: 762px; border: 1px solid balck; text-align: center;"
			cellpadding="1" cellspacing="0" align="center">
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

			<form action="" method="post">
				<table cellspacing="0" cellpadding="0" width="350" align="center"
					bgcolor="#FFFF99" border="0">
					<tbody>
						<tr>
							<td align="right" height="25">Username: &nbsp; <input tabindex="1"
								type="text" maxlength="20" size="20" name="username">
							</td>
						</tr>
						<tr>
							<td align="right">Password: &nbsp; <input tabindex="2" type="password"
								maxlength="20" size="20" name="password">
							</td>
						</tr>
						<tr>
							<td align="right">Repeat Password: &nbsp; <input tabindex="3" type="password"
								maxlength="20" size="20" name="repassword">
							</td>
						</tr>
						<tr>
							<td align="right">Name: &nbsp; <input tabindex="3" type="text"
								maxlength="20" size="20" name="name">
							</td>
						</tr>
						<tr>
							<td align="right">Email: &nbsp; <input tabindex="3" type="text"
								maxlength="40" size="20" name="email">
							</td>
						</tr>
						<tr>
							<td align="right">User Level (1-3 default 1): &nbsp; <input tabindex="3"
								type="text" maxlength="1" size="20" name="level" value="1">
							</td>
						</tr>
						<tr>
							<td align="right">Administrator (1 for Yes, 0 for No): &nbsp; <input tabindex="3"
								type="text" maxlength="1" size="20" name="admin_level" value="0">
							</td>
						</tr>
						<tr>
							<td align="right">Subcription (Days): &nbsp; <input tabindex="3" type="text"
								maxlength="20" size="20" name="cycle" value="30">
							</td>
						</tr>
						<tr>
							<td align="right">Data (GB)：&nbsp; <input tabindex="3" type="text"
								maxlength="20" size="20" name="quota_bytes" value="10">
							</td>
						</tr>
						<tr>
							<td align="right">Status: (1 is Active): &nbsp; <input tabindex="3" type="text"
								maxlength="20" size="20" name="active" value="1">
							</td>
						</tr>
						<tr>
							<td align="right">Enabled: &nbsp; <input tabindex="3" type="text"
								maxlength="20" size="20" name="enable" value="1">
							</td>
						</tr>
						<tr>
							<td align="middle" height="25"><input id="new_user"
								style="BORDER-RIGHT: 0px; BORDER-TOP: 0px; BORDER-LEFT: 0px; WIDTH: 65px; CURSOR: hand; BORDER-BOTTOM: 0px; HEIGHT: 18px"
								type="submit" value="Add User" name="new_user"> <input id="reset"
								style="BORDER-RIGHT: 0px; BORDER-TOP: 0px; BORDER-LEFT: 0px; WIDTH: 52px; CURSOR: hand; BORDER-BOTTOM: 0px; HEIGHT: 18px"
								type="reset" value="Reset" name="reset">
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>
	<?php
            }
            ?>
</body>
</html>
