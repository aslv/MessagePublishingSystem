<?php
session_start();
mb_internal_encoding('UTF-8');
//echo basename($_SERVER['PHP_SELF']);

if ((!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] !== true) && basename($_SERVER['PHP_SELF']) != 'index.php') 
{
	header('Location: index.php');
	exit;
}
