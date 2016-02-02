<?php
include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$u_id = mysql_real_escape_string($_REQUEST['u_id']);
$sql = "DELETE FROM `user` WHERE `user_id` = '$u_id' ";
$query = $database->executeStatement($sql);
if ($query) {
    $arr = array("result" => "yes");
} else {
    $arr = array("result" => "no");
}
echo json_encode($arr);
?>
