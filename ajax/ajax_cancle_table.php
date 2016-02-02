<?php

include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$tb = mysql_real_escape_string($_REQUEST['table']);
$sql_order_update = "UPDATE `order` SET `order_status`='1' WHERE `table_id` = '$tb' AND `order_status`='0' ";
$query_order_update = $database->executeStatement($sql_order_update);
if ($query_order_update) {
    $sql_table = "UPDATE `table_detail` SET `tb_status_id` = '1' WHERE `table_id` = '$tb' ";
    $query_table = $database->executeStatement($sql_table);
    if ($query_table) {
        $arr = array("result" => "ok");
    } else {
        $arr = array("result" => "no");
    }
}
echo json_encode($arr);
?>
