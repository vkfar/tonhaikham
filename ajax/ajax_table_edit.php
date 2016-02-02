<?php

include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$tb_name = mysql_real_escape_string($_REQUEST["tb_name"]);
$tb_id = mysql_real_escape_string($_REQUEST["tb_id"]);
if ($database->executeStatement_numrow("SELECT * FROM `table_detail` WHERE `table_name` = '$tb_name' AND `table_id` != '$tb_id' LIMIT 1 ") > 0) {
    $arr = array("result" => "yes", "msg" => "Table name is duplicate");
} else {
    $sql = "UPDATE `table_detail` SET `table_name` = '$tb_name' WHERE `table_id` = '$tb_id' ";
    $query = $database->executeStatement($sql);
    if ($query) {
        $arr = array("result" => "yes", "msg" => "no");
    } else {
        $arr = array("result" => "no");
    }
}
echo json_encode($arr);
?>
