<?php
include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$name = mysql_real_escape_string($_REQUEST["name"]);
$add = mysql_real_escape_string($_REQUEST["add"]);
$tell = mysql_real_escape_string($_REQUEST["tell"]);
$foot = mysql_real_escape_string($_REQUEST["foot"]);
$sql = "UPDATE `bill_setting` SET `name` = '$name', `address` = '$add', `tell` = '$tell', `footer` = '$foot' ";
$query = $database->executeStatement($sql);
if ($query) {
    $arr = array("result" => "yes");
} else {
    $arr = array("result" => "no");
}
echo json_encode($arr);
?>
