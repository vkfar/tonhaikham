<?php

include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();

$tb_name = mysql_real_escape_string($_REQUEST["tb_name"]);
$tb_status = mysql_real_escape_string($_REQUEST["tb_status"]);

// check name by num row 

if ($database->executeStatement_numrow("SELECT * FROM `table_detail` WHERE `table_name` = '$tb_name' LIMIT 1 ") > 0) {
    $arr = array("result" => "yes","msg"=>"Table name is duplicate");
} else {
    $sql = "INSERT INTO `table_detail` VALUES('','$tb_name','1')";
    $query = $database->executeStatement($sql);
    if ($query) {
        $arr = array("result" => "yes","msg"=>"no");
    } else {
        $arr = array("result" => "no");
    }
}

echo json_encode($arr);
?>
