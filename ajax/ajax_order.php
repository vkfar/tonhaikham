<?

include '../includes/config.inc.php';
$sys_user_id = $_SESSION["sess_user_id"];
// connect database 
$database = new Database();
$database->openConnection();

$table = mysql_real_escape_string($_REQUEST['table']);
$item = mysql_real_escape_string($_REQUEST['item']);

$sql = "SELECT * FROM `order` WHERE `table_id`='$table' AND `order_status`='0' LIMIT 1";
$order_arr = $database->executeSql($sql);

// first time making order
if (count($order_arr) == 0) {
    $sql = "INSERT INTO `order` VALUES('','$table',NOW(),'0','0','0','0')";
    $query = $database->executeStatement($sql);
    //update table status
    $sql = "UPDATE `table_detail` SET `tb_status_id` = '2' WHERE `table_id`='$table' ";

    $query = $database->executeStatement($sql);
    //end update
    $sql = "SELECT * FROM `order` WHERE `table_id`='$table' AND `order_status`='0' LIMIT 1";
    $order_arr = $database->executeSql($sql);
}
////////////////////////////////////////////////////////////////



$order_id = $order_arr[0]->order_id;

$sql_item = "SELECT * FROM menu WHERE menu_id='$item' ";
$item_arr = $database->executeSql($sql_item);
$item_price = $item_arr[0]->menu_price;

$sql = "INSERT INTO `order_detail` VALUES('','$item','$order_id','$sys_user_id','$item_price','1',NOW(),'0')";

$query = $database->executeStatement($sql);
if ($query) {
    $arr = array("result" => "ok");
} else {
    $arr = array("result" => "no");
}
echo json_encode($arr);

