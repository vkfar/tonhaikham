<?

include '../includes/config.inc.php';

// connect database 
$database = new Database();
$database->openConnection();

$mem_code = mysql_real_escape_string($_REQUEST['mem_code']);
$tb_id = mysql_real_escape_string($_REQUEST['table']);
$sql_member = "SELECT `mem_id`, `discount_rate` FROM `member` INNER JOIN `discount` ON `member`.discount_id = `discount`.discount_id WHERE `member`.mem_code = '$mem_code' ";
$member_arr = $database->executeSql($sql_member);

if (count($member_arr) > 0) {
    $discount_rate = $member_arr[0]->discount_rate;
    $mem_id = $member_arr[0]->mem_id;
    $sql_order = "UPDATE `order` SET `mem_id` = '$mem_id', `discount_rate_due_order` = '$discount_rate' WHERE `table_id` = '$tb_id' AND `order_status` = '0' ";
    $query = $database->executeStatement($sql_order);
    if ($query) {
        $arr = array("result" => "yes","result_txt"=>"yes");
    } else {
        $arr = array("result" => "no");
    }
}else{
    $arr = array("result" => "yes","result_txt"=>"Incorrect Member Code!");
}



echo json_encode($arr);

?>