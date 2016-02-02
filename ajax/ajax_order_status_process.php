<?php

include '../includes/config.inc.php';
// connect database 
$database = new Database();
$orderdetail_id = mysql_real_escape_string($_REQUEST['id']);
$btn = mysql_real_escape_string($_REQUEST['btn']);

$btn_arr['cook'] = 2;
$btn_arr['cook_finish'] = 3;
$btn_arr['can_not_cook'] = 4;
$btn_arr['cook_finish_serve'] = 5;
$btn_arr['can_not_cook_serve'] = 6;


$sql = "UPDATE  `order_detail` SET `order_detail_status` = '" . $btn_arr[$btn] . "' WHERE `order_detail_id` = '$orderdetail_id' ";
if ($database->executeStatement($sql)) {
    $arr = array("result" => "ok" );
} else {
    $arr = array("result" => "no");
}
echo json_encode($arr);
?>
