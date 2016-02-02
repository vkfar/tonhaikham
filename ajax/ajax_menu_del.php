<?php

include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$menu_item_id = mysql_real_escape_string($_REQUEST["menu_item_id"]);
$sql_menu = "SELECT * FROM `menu` WHERE `menu_id` = '$menu_item_id' ";
$menu_item_arr = $database->executeSql($sql_menu);
$sql = "DELETE FROM `menu` WHERE `menu_id` = '$menu_item_id' ";
$query = $database->executeStatement($sql);
if ($query) {
    if ($menu_item_arr[0]->menu_img != "" AND file_exists("../img_product/" . $menu_item_arr[0]->menu_img)) {
        unlink("../img_product/" . $menu_item_arr[0]->menu_img);
    }
    $arr = array("result" => "yes");
} else {
    $arr = array("result" => "no");
}
echo json_encode($arr);
?>
