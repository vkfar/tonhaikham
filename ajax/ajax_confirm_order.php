<?

include '../includes/config.inc.php';

// connect database 
$database = new Database();
$database->openConnection();

$table = mysql_real_escape_string($_REQUEST['table']);
$sql_order = "SELECT * FROM `order` WHERE `table_id`='$table' AND `order_status`='0' LIMIT 1";
$order_arr = $database->executeSql($sql_order);
$order_id = $order_arr[0]->order_id;
$sql_u_order_d = "UPDATE `order_detail` SET order_detail_status = '1' WHERE order_id = '$order_id' AND order_detail_status = '0' ";
$query = $database->executeStatement($sql_u_order_d);
if ($query) {
    $arr = array("result" => "ok");
} else {
    $arr = array("result" => "no");
}
echo json_encode($arr);

