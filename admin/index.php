<!doctype html>
<html>
<head>
<?php include_once('header.php'); ?>
<title>Admininstrator Panel</title>
</head>
<body>
	<?php
	if (!(isset($_SESSION["success"]) && $_SESSION["success"] == true)) {
		//  Validation failed with $ _SESSION ["success"] set to false
		$_SESSION["success"] = false;
		echo("<meta http-equiv=refresh content='0; url=login.php'>");
	} else {

		function sizeformat($bytesize)
		{
			$i=0;
			while(abs($bytesize) >= 1024)
			{
				$bytesize=$bytesize/1024;
				$i++;
				if($i==4) break;
			}
			$units = array("BIT","KB","MB","GB","TB");
			$newsize=round($bytesize,2);
			return("$newsize $units[$i]");
		}

		function actformat($value)
		{
			if ($value==1){
				return "active";
			}
			else{
				return "disable";
			}
		}

		$sql="SELECT username,name,email,quota_cycle,quota_bytes,used_quota,left_quota,active FROM  `user`";
		$result=mysql_query($sql);
		?>
	<div align="center">
		<table
			style="width: 762px; border: 1px solid black; border-bottom: 0px; margin-top: 10px"
			cellpadding="1" cellspacing="0">
			<?php while($row = mysql_fetch_array($result)){ ?>
			<tr class="Title_style2">
				<td width="25%">
					<div align="left">
						<a> Username</a>
					</div>
				</td>

				<td width="25%">
					<div align="left">
						<a> Name</a>
					</div>
				</td>

				<td width="25%">
					<div align="left">
						<a> Email</a>
					</div>
				</td>

				<td width="25%">
					<div align="left">
						<a>Status</a>
					</div>
				</td>
			</tr>
			<tr class="Content_style1">
				<td><?php echo $row['username'] ?></td>
				<td><?php echo $row['name'] ?></td>
				<td><?php echo $row['email'] ?></td>
				<td><?php if($row['active']==1){
					echo "Active";
				}
				else{
						echo "Disable";
					} ?>
				</td>
			</tr>
			<tr></tr>
			<tr class="Title_style2">

				<td width="25%">
					<div align="left">
						<a> Cycle</a>
					</div>
				</td>

				<td width="25%">
					<div align="left">
						<a> Total</a>
					</div>
				</td>

				<td width="25%">
					<div align="left">
						<a> Total Usage</a>
					</div>
				</td>

				<td width="25%">
					<div align="left">
						<a> Remaining Data</a>
					</div>
				</td>
			</tr>
			<tr class="Content_style1">
				<td><?php echo $row['quota_cycle'] ?></td>

				<td><?php echo sizeformat($row['quota_bytes']) ?></td>

				<td><?php echo  sizeformat($row['used_quota']) ?></td>

				<td><?php echo  sizeformat($row['left_quota']) ?></td>
			</tr>
			<tr><td colspan=4 style="height:10px;"></td></tr>
			<?php } ?>
		</table>
		<p align="center" class="Content_style1">This page is refreshed every 5 minutes</p>
	</div>
	<?php 
	mysql_close($conn);
} ?>
</body>
</html>
