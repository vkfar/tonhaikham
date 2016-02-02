<?php
include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$old_table = mysql_real_escape_string($_REQUEST['old_t']);
$new_table = mysql_real_escape_string($_REQUEST['new_t']);
$sql = "UPDATE `order` SET `table_id` = '$new_table' WHERE `table_id` = '$old_table' AND `order_status` = '0'  ";
$query = $database->executeStatement($sql);
$sql = "UPDATE `table_detail` SET `tb_status_id` = '1' WHERE `table_id` = '$old_table' ";
$query = $database->executeStatement($sql);
$sql = "UPDATE `table_detail` SET `tb_status_id` = '2' WHERE `table_id` = '$new_table' ";
$query = $database->executeStatement($sql);
if ($query) {
    $arr = array("result" => "yes");
} else {
    $arr = array("result" => "no");
}
echo json_encode($arr);
?>
