<?php
//After the form is submitted...
$posts = $_POST;
//Clear some blank symbols
foreach ($posts as $key => $value) {
	$posts[$key] = trim($value);
}

if(isset($_POST['install'])){
	$mysql_server_name=mysql_real_escape_string($posts['hostname']);
	$mysql_username=mysql_real_escape_string($posts['db_username']);
	$mysql_password=mysql_real_escape_string($posts['db_password']);
	$mysql_dbname=mysql_real_escape_string($posts['db_name']);
	$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die(mysql_error());
	if (mysqli_connect_errno($conn))
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		break;
	}
	else{
		//Write the configuration file
		write_config($mysql_server_name, $mysql_username, $mysql_password, $mysql_dbname);
	}
	//Create a database connection database
	$db_selected = mysql_select_db($mysql_dbname);
	if(!$db_selected) {
		$sql="CREATE DATABASE IF NOT EXISTS `$mysql_dbname` CHARACTER SET utf8 COLLATE utf8_unicode_ci";
		$result=mysql_query($sql);
		if(!$result){
			die('Cannot create database: ' . mysql_error());
			break;
		}
		else{
			$db_selected = mysql_select_db($mysql_dbname, $conn);
			if(!$db_selected){
				die('Cannot create database: ' . mysql_error());
				break;
			}
		}
	}
	//Performs database initialization
	if(file_exists('./database.sql')){
		run_sql_file('./database.sql');
	}
	else{
		echo "Can not find database.sql in the installation folder. Check the integrity of the folder.";
		break;
	}
	$admin_username = mysql_real_escape_string($posts['admin_username']);
	$admin_passwd	= mysql_real_escape_string($posts['admin_passwd']);
	$admin_email	= mysql_real_escape_string($posts['email']);
	//Add an administrator
	$sql="INSERT INTO  `$mysql_dbname`.`admin` (`id` ,`username` ,`password` ,`email` ,`admin_level`)
			VALUES (NULL , '$admin_username',
			password('$admin_passwd'), '$admin_email',  '3')";
	$result=mysql_query($sql);
	if(!$result){
		echo("Adminstrator account added failed!".mysql_errno());
		break;
	}
	else{
		echo("Administrator account added successfully!\n
				Username: ".mysql_real_escape_string($posts['admin_username'])."\n
				Password: ".mysql_real_escape_string($posts['admin_passwd'])."\n
				Email: ".mysql_real_escape_string($posts['email']));
	}
	write_lock();
	break;
}



/**
* Write the configuration file to the data folder
  * @param string $ mysql_server_name The server name
  * @param string $ mysql_username database user name
  * @param string $ mysql_password Database password
  * @param string $ mysql_dbname The database name
 */
function write_config($mysql_server_name,$mysql_username,$mysql_password,$mysql_dbname){
	$configFile = "./data/config.inc.php";
	$fh = fopen($configFile, 'w') or die();
	$stringData = "<?php\n
	// database host\n
	".'$db_host'." ='$mysql_server_name';\n
	// database username\n
	".'$db_user'." = '$mysql_username';\n
	// database password\n
	".'$db_pass'." = '$mysql_password';\n
	// database name\n
	".'$db_name'." = '$mysql_dbname';\n
	?>";
	fwrite($fh, $stringData);
	fclose($fh);
}

function write_lock(){
	$lockFile = "./data/install.lock";
	$fh = fopen($lockFile, 'w') or die();
	$stringData = " ";
	fwrite($fh, $stringData);
	fclose($fh);
}

function run_sql_file($file){
	//load file
	$commands = file_get_contents($file);
	
	//echo "\n".$commands."\n";
	//delete comments
	$lines = explode("\n",$commands);
	$commands = '';
	foreach($lines as $line){
		//echo "\n".$line."\n";
		$line = trim($line);
		if( $line && !startsWith($line,'/*') ){
			$commands .= $line . "\n";
		}
	}
	//convert to array
	$commands = explode(";", $commands);
	//run commands
	$total = $success = 0;
	echo("<div>");
	foreach($commands as $command){
		echo "<br>";
		if(trim($command)){
			$success += (@mysql_query($command)==false ? 0 : 1);
			$total += 1;
			echo("<br>".$command."<br>");
		}
	}
	echo("</div>");
	//return number of successful queries and total number of queries found
	return array(
			"success" => $success,
			"total" => $total
	);
}

function startsWith($haystack, $needle){
	$length = strlen($needle);
	return (substr($haystack, 0, $length) === $needle);
}

?>
