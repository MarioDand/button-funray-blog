<?php
if (!isset($_SESSION)) {
    session_start();
}

//if(isset($_SESSION['timeout'])) {
//    // See if the number of seconds since the last
//    // visit is larger than the timeout period.
//    $duration = time() - (int)$_SESSION['timeout'];
//    if($duration > $timeout) {
//        // Destroy the session and restart it.
//
//        session_start();
//    }
//}

//session_destroy();

ob_start();
date_default_timezone_set('Europe/Sofia');

$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "";
$mysql_database = "blog";

$db = new PDO( "mysql:host=$mysql_hostname;dbname=$mysql_database", $mysql_user,  $mysql_password );
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


