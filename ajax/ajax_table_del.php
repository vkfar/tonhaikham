<?php
include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$tb_id = mysql_real_escape_string($_REQUEST['tb_id']);
$sql = "DELETE FROM `table_detail` WHERE `table_id` = '$tb_id' ";
$query = $database->executeStatement($sql);
if ($query) {
    $arr = array("result" => "yes");
} else {
    $arr = array("result" => "no");
}
echo json_encode($arr);
?>
