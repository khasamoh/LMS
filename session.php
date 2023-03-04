<?php
session_start();
if (!empty($_SESSION['UID']) && !empty($_SESSION['Privl']))
{
	$_SESSION['UID'];
	$_SESSION['Name'];
	$_SESSION['Privl'];	
}else
{
header("location:index.php");
}

?>