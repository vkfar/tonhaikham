<?php

include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$menu_type = mysql_real_escape_string($_REQUEST["menu_type"]);
$menu_id = mysql_real_escape_string($_REQUEST["menu_id"]);

if ($database->executeStatement_numrow("SELECT * FROM `menu_category` WHERE `menu_cate_name` = '$menu_type' AND `menu_cate_id` != '$menu_id' LIMIT 1 ") > 0) {
    $arr = array("result" => "yes", "msg" => "Menu Category is duplicate");
} else {

    if (valid_array_string(array($menu_type))) {
        $arr = array("result" => "yes", "msg" => "Enter Menu Category");
    } else {
        $sql = "UPDATE `menu_category` SET `menu_cate_name` = '$menu_type' WHERE `menu_cate_id` = '$menu_id' ";
        $query = $database->executeStatement($sql);
        if ($query) {
            $arr = array("result" => "yes", "msg" => "no");
        } else {
            $arr = array("result" => "no");
        }
    }
}
echo json_encode($arr);
?>
