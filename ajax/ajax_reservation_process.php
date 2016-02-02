<?php

include '../includes/config.inc.php';

// connect database 
$database = new Database();
$database->openConnection();
$sys_user_id = $_SESSION["sess_user_id"];

$table_id = mysql_real_escape_string($_REQUEST['table']);
$reservation_id = mysql_real_escape_string($_REQUEST['reservation_id']);
$type = mysql_real_escape_string($_REQUEST['type']);

if ($type == "confirm") {
    $sql_s = "UPDATE `table_detail` SET `tb_status_id` = '1' WHERE `table_id`='$table_id' ";
    $sql_r = "UPDATE `reservation` SET `reserve_status` = '3' WHERE `reserve_id`='$reservation_id' ";
} else if ($type == "cancle") {
    $sql_s = "UPDATE `table_detail` SET `tb_status_id` = '1' WHERE `table_id`='$table_id' ";
    $sql_r = "UPDATE `reservation` SET `reserve_status` = '2' WHERE `reserve_id`='$reservation_id' ";
} else if ($type == "delete") {
    $sql_s = "UPDATE `table_detail` SET `tb_status_id` = '1' WHERE `table_id`='$table_id' ";
    $sql_r = "DELETE FROM `reservation` WHERE `reserve_id`='$reservation_id' ";
}

$query_s = $database->executeStatement($sql_s);
$query_r = $database->executeStatement($sql_r);

if ($query_s && $query_r) {
    $arr = array("result" => "ok");
} else {
    $arr = array("result" => "no");
}
echo json_encode($arr);
?>
