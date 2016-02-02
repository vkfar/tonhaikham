<?

include '../includes/config.inc.php';

// connect database 
$database = new Database();
$database->openConnection();
$tb_id = mysql_real_escape_string($_REQUEST['table']);
$sql_order = "UPDATE `order` SET `mem_id` = '0', `discount_rate_due_order` = '0' WHERE `table_id` = '$tb_id' AND `order_status` = '0' ";
$query = $database->executeStatement($sql_order);
if ($query) {
    $arr = array("result" => "yes");
} else {
    $arr = array("result" => "no");
}

echo json_encode($arr);

?>