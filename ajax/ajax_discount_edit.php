<?php

include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();

$discount_id = mysql_real_escape_string($_REQUEST["discount_id"]);
$discount= mysql_real_escape_string($_REQUEST["discount"]);
$rate= mysql_real_escape_string($_REQUEST["rate"]);

if ($database->executeStatement_numrow("SELECT * FROM `discount` WHERE `discount` = '$discount' AND `discount_id` != '$discount_id' LIMIT 1 ") > 0) {
    $arr = array("result" => "yes", "msg" => "Discount is duplicate");
} else {
    $sql = "UPDATE `discount` SET `discount` = '$discount', `discount_rate` = '$rate' WHERE `discount_id` = '$discount_id' ";
    $query = $database->executeStatement($sql);
    if ($query) {
        $arr = array("result" => "yes", "msg" => "no");
    } else {
        $arr = array("result" => "no");
    }
}
echo json_encode($arr);
?>
