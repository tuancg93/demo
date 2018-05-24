<?php
ob_start();
ini_set('error_reporting', E_ALL);
session_start();
header('Content-Type: text/html; charset=utf-8');

//ini_set('error_reporting', 0);
include("config.php");
foreach (glob("core/*.php") as $filename)
{
    include $filename;
}


include("routes.php");


	
?>