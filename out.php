<?php
session_start();
$_SESSION['UID'];
$_SESSION['Name'];
$_SESSION['Privl'];

session_destroy();
header("Location:index.php")
?>