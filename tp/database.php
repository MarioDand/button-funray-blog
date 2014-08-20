<?php
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "";
$mysql_database = "cdcol";

$db = new PDO( "mysql:host=$mysql_hostname;dbname=$mysql_database", $mysql_user,  $mysql_password );
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);