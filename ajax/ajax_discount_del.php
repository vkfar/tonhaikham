<?php
include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$discount_id = mysql_real_escape_string($_REQUEST['discount_id']);
$sql = "DELETE FROM `discount` WHERE `discount_id` = '$discount_id' ";
$query = $database->executeStatement($sql);
if ($query) {
    $arr = array("result" => "yes");
} else {
    $arr = array("result" => "no");
}
echo json_encode($arr);
?>
