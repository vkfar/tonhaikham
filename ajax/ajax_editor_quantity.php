<?php

include '../includes/config.inc.php';
// connect database 

$sys_user_id = $_SESSION["sess_user_id"];

$database = new Database();
$database->openConnection();
$orderdetail_id = mysql_real_escape_string($_REQUEST['item']);
$quantity = mysql_real_escape_string($_REQUEST['quantity']);

$orderdetail_sql = "SELECT * FROM `order_detail` WHERE `order_detail_id`='$orderdetail_id' ";
$orderdetail_arr = $database->executeSql($orderdetail_sql);
$total_price = ($orderdetail_arr[0]->menu_price)*$quantity;
$sql = "UPDATE `order_detail` SET `order_quantity` = '$quantity' ,`user_id` = '$sys_user_id' WHERE `order_detail_id`='$orderdetail_id' ";
$query = $database->executeStatement($sql);
if ($query) {
    $arr = array("result" => "ok");
} else {
    $arr = array("result" => "no");
}
echo json_encode($arr);
?>
