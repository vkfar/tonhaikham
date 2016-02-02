<?php
$user = $_REQUEST["user"];
$pass = $_REQUEST["pass"];
$db = $_REQUEST["db"];

@mysql_connect("localhost", $user, $pass) or die("Cannot connect mysql!");
@mysql_select_db($db) or die("Cannot connect database!");
$file = '../includes/database.inc.php';
// Open the file to get existing content
$wirte = "<?
    defined('DATABASE_HOST') ? NULL : define('DATABASE_HOST', 'localhost');
defined('DATABASE_NAME') ? NULL : define('DATABASE_NAME', '$db');
defined('DATABASE_USER') ? NULL : define('DATABASE_USER', '$user');
defined('DATABASE_PASSWORD') ? NULL : define('DATABASE_PASSWORD', '$pass');
        ?>";
// Write the contents back to the file
if (file_put_contents($file, $wirte)) {
    echo "Complete! Don't forget to delete install folder in program!";
}else{
      echo "Cannot save information!";
}
?>
