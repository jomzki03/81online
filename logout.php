<!doctype html>
<html>
<head>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<?php
session_start();
/ / This method is to destroy the entire Session file
/ / This method is the original registration of a variable destroyed
unset($_SESSION['admin']);
session_destroy();
echo("Successfully logged out! Redirecting to login page!");
echo("<meta http-equiv=refresh content='2; url=login.php'>"); 
?>
</html>
