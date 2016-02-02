<?php

include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$menu_type = mysql_real_escape_string($_REQUEST["menu_type"]);

if ($database->executeStatement_numrow("SELECT * FROM `menu_category` WHERE `menu_cate_name` = '$menu_type' LIMIT 1 ") > 0) {
    $arr = array("result" => "yes", "msg" => "Menu Category is duplicate");
} else {

    $sql = "INSERT INTO `menu_category` VALUES('','$menu_type')";
    $query = $database->executeStatement($sql);
    if (valid_array_string(array($menu_type))) {
        $arr = array("result" => "yes", "msg" => "Enter Menu Category");
    } else {
        if ($query) {
            $arr = array("result" => "yes", "msg" => "no");
        } else {
            $arr = array("result" => "no");
        }
    }
}
echo json_encode($arr);
?>
