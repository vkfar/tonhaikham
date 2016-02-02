<?php

include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();

$discount = mysql_real_escape_string($_REQUEST["discount"]);
$rate = mysql_real_escape_string($_REQUEST["rate"]);

// check name by num row 

if ($database->executeStatement_numrow("SELECT * FROM `discount` WHERE `discount` = '$discount' LIMIT 1 ") > 0) {
    $arr = array("result" => "yes","msg"=>"Discount is duplicate");
} else {
    $sql = "INSERT INTO `discount` VALUES('','$discount','$rate')";
    $query = $database->executeStatement($sql);
    if ($query) {
        $arr = array("result" => "yes","msg"=>"no");
    } else {
        $arr = array("result" => "no");
    }
}

echo json_encode($arr);
?>
