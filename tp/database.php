<?php
session_start();
$timeout = 10;

if(isset($_SESSION['timeout'])) {
    // See if the number of seconds since the last
    // visit is larger than the timeout period.
    $duration = time() - (int)$_SESSION['timeout'];
    if($duration > $timeout) {
        // Destroy the session and restart it.
        session_destroy();
        session_start();
    }
}

ob_start();
date_default_timezone_set('Europe/Sofia');

$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "";
$mysql_database = "blog";

$db = new PDO( "mysql:host=$mysql_hostname;dbname=$mysql_database", $mysql_user,  $mysql_password );
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function create_hash($value)
{
    return $hash = crypt($value, '$2a$12$'.substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22));
}
