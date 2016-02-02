<?php

include '../includes/config.inc.php';

// connect database 
$database = new Database();
$database->openConnection();
$sys_user_id = $_SESSION["sess_user_id"];

$reservation_id = mysql_real_escape_string($_REQUEST['reservation_id']);
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
        
        $sql_r = "UPDATE `reservation` SET user_id = '$sys_user_id', reserve_name = '$name', reserve_tel = '$tell', reserve_on_date = '$date', reserve_note = '$note' WHERE reserve_id = '$reservation_id' ";
        $query_r = $database->executeStatement($sql_r);
        if ($query_r) {
             $arr = array("result" => "ok", "msg" => "no");
        } else {
            $arr = array("result" => "no");
        }
        
    }
}



echo json_encode($arr);
?>
