<!doctype html>
<html>
<head>
<?php include_once('header.php'); ?>
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
	
	$sql="SELECT stat.*,user.active,user.quota_cycle,user.quota_bytes,user.left_quota,user.level FROM stat,user WHERE stat.username = '$username' and user.username='$username' GROUP BY stat.username";
	
	//mysqli_query("SET NAMES gbk");
	
	$result=mysql_query($sql);
	
	$row=mysql_fetch_row($result);
	?>

<div align="center" >
	<table style="width: 762px; border: 1px solid black; border-bottom:0px; margin-top:10px" cellpadding="1"
		cellspacing="0">
		<tr class="Title_style2">

			<td width="25%">
				<div align="left">
					<a> Username</a>
				</div>
			</td>

			<td width="25%">
				<div align="left">
					<a> Starting Time </a>
				</div>
			</td>

			<td width="25%">
				<div align="left">
					<a> Statistical Period</a>
				</div>
			</td>

			<td width="25%">
				<div align="left">
					<a></a>
				</div>
			</td>
		</tr>
		<tr class="Content_style1">

			<td><?php echo $row[1] ?></td>

			<td><?php echo $row[2] ?></td>

			<td><?php echo $row[4] ?>Day</td>

		</tr>
		<tr></tr>
		<tr class="Title_style2">

			<td width="25%">
				<div align="left">
					<a> User Status</a>
				</div>
			</td>

			<td width="25%">
				<div align="left">
					<a> Total Traffic</a>
				</div>
			</td>

			<td width="25%">
				<div align="left">
					<a> Total Usage</a>
				</div>
			</td>

			<td width="25%">
				<div align="left">
					<a> Remaining Traffic</a>
				</div>
			</td>
		</tr>
		<tr class="Content_style1">
			<td><?php echo actformat($row[3]) ?></td>

			<td><?php echo sizeformat($row[5]) ?></td>

			<td><?php echo  sizeformat($row[0]) ?></td>

			<td><?php echo  sizeformat($row[6]) ?></td>
		</tr>
	</table>
	<p align="center" class="Content_style1">This page is refreshed every 5 minutes.</p>
</div>
<?php 
mysqli_close($conn);
} ?>
</body>
</html>
