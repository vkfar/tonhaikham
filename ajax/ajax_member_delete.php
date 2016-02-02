<?php
include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$memid = mysql_real_escape_string($_REQUEST['memid']);
$sql = "DELETE FROM `member` WHERE `mem_id` = '$memid' ";
$query = $database->executeStatement($sql);
if ($query) {
    $arr = array("result" => "yes");
} else {
    $arr = array("result" => "no");
}
echo json_encode($arr);
?>
