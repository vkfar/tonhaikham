<?php
include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();

$sys_user = $_SESSION["sess_user"];
$sys_user_id = $_SESSION["sess_user_id"];
$sys_user_role = $_SESSION["sess_user_role"];

$ordernum_id = mysql_real_escape_string(trim($_REQUEST['id']));
$sql_order_update = "UPDATE `order` SET `order_status`='1', `user_id` = '$sys_user_id', `order_date` = NOW() WHERE `order_id` = '$ordernum_id' ";

$query_order_update = $database->executeStatement($sql_order_update);
if ($query_order_update) {
    $sql_order_detail = "SELECT * FROM `order` WHERE `order_id` = '$ordernum_id' ";
    $order_detail_arr = $database->executeSql($sql_order_detail);
    $tb = $order_detail_arr[0]->table_id;
    $sql_table = "UPDATE `table_detail` SET `tb_status_id` = '1' WHERE `table_id` = '$tb' ";
    $query_table = $database->executeStatement($sql_table);
    if($query_table){
        $arr = array("result" => "yes");
    }else{
            $arr = array("result" => "no");
    }   
} else {
    $arr = array("result" => "no");
}
echo json_encode($arr);
?>
