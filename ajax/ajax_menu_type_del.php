<?php

include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$menu_id = mysql_real_escape_string($_REQUEST["menu_id"]);
$sql = "DELETE FROM `menu_category` WHERE `menu_cate_id` = '$menu_id' ";
$query = $database->executeStatement($sql);
if ($query) {
    $sql_item = "DELETE FROM `menu` WHERE `menu_id` = '$menu_id' ";
    $query_item = $database->executeStatement($sql_item);
    if ($query_item) {
        $arr = array("result" => "yes");
    } else {
        $arr = array("result" => "no");
    }
} else {
    $arr = array("result" => "no");
}
echo json_encode($arr);
?>
