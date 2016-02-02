<?php

include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$orderdetail_id = mysql_real_escape_string($_REQUEST['item']);
$tb = mysql_real_escape_string($_REQUEST['table']);
//SELETE DETAIL
$orderdetail_sql = "SELECT * FROM `order_detail` WHERE `order_detail_id`='$orderdetail_id' ";
$orderdetail_arr = $database->executeSql($orderdetail_sql);
$order_id = $orderdetail_arr[0]->order_id;

//DELET ORDER
$sql = "DELETE FROM `order_detail` WHERE `order_detail_id` = '$orderdetail_id' ";
$query = $database->executeStatement($sql);

if ($query) {
    // IF HAVE ONLY ONE ORDER UPDATE TABLE AND DELETE ORDER
    $sql_count_orderdetail = "SELECT * FROM `order_detail` WHERE `order_id` = '$order_id' ";
    if ($database->executeStatement_numrow($sql_count_orderdetail) == 0) {
        $sql_table = "UPDATE `table_detail` SET `tb_status_id` = '1' WHERE `table_id` = '$tb' ";
        $query_table = $database->executeStatement($sql_table);
        $sql_order_delete = "DELETE FROM `order` WHERE `order_id` = '$order_id' ";
        $query_order_delete = $database->executeStatement($sql_order_delete);
    }
    $arr = array("result" => "ok");
} else {
    $arr = array("result" => "no");
}
echo json_encode($arr);
?>
