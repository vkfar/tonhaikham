<?php

include '../includes/config.inc.php';

// connect database 
$database = new Database();
$database->openConnection();
$sys_user_id = $_SESSION["sess_user_id"];

$table_id = mysql_real_escape_string($_REQUEST['table']);
$name = mysql_real_escape_string($_REQUEST['name']);
$date = mysql_convert_string_to_date_time(mysql_real_escape_string($_REQUEST['date'])) . ":00";
$tell = mysql_real_escape_string($_REQUEST['tell']);
$note = mysql_real_escape_string($_REQUEST['note']);



if (valid_array_string(array($name, $_REQUEST['date'], $tell))) {
    $arr = array("result" => "ok", "msg" => "Please Enter Customer name, tel, Reservation on!");
} else {
    if (!is_numeric($tell)) {
         $arr = array("result" => "ok", "msg" => "Tel is only number!");
    } else {
        $sql_s = "UPDATE `table_detail` SET `tb_status_id` = '3' WHERE `table_id`='$table_id' ";
        $query_s = $database->executeStatement($sql_s);
        $sql_r = "INSERT INTO `reservation` VALUES('','$table_id','$sys_user_id','$name','$tell',NOW(),'$date','1','$note')";

        $query_r = $database->executeStatement($sql_r);
        if ($query_s && $query_r) {
            $arr = array("result" => "ok", "msg" => "no");
        } else {
            $arr = array("result" => "no");
        }
    }
}

echo json_encode($arr);
?>
