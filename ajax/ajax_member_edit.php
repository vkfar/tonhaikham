<?php

include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();

$memid = mysql_real_escape_string($_REQUEST["memid"]);
$memcode = mysql_real_escape_string($_REQUEST["memcode"]);
$memstart = convert_date_to_mysql(mysql_real_escape_string($_REQUEST["memstart"]));
$memex = convert_date_to_mysql(mysql_real_escape_string($_REQUEST["memex"]));
$memname = mysql_real_escape_string($_REQUEST["memname"]);
$memsurname = mysql_real_escape_string($_REQUEST["memsurname"]);
$memadd = mysql_real_escape_string($_REQUEST["memadd"]);
$memtell = mysql_real_escape_string($_REQUEST["memtell"]);
$memremark = mysql_real_escape_string($_REQUEST["memremark"]);
$memdiscount = mysql_real_escape_string($_REQUEST["memdiscount"]);
$memstatus = mysql_real_escape_string($_REQUEST["memstatus"]);

if ($database->executeStatement_numrow("SELECT * FROM `member` WHERE `mem_code` = '$memcode' AND `mem_id` != '$memid' LIMIT 1 ") > 0) {
    $arr = array("result" => "yes", "msg" => "Member Code is duplicate");
} else {
    if (!is_numeric($memtell)) {
        $arr = array("result" => "yes", "msg" => "Tel is only number");
    } else {
        if (valid_array_string(array($memcode, $memstart, $memex, $memname, $memsurname, $memadd))) {
            $arr = array("result" => "yes", "msg" => "Make sure you have enter member code, issue date, expire date, name, surname, address, tel");
        } else {
            if ($memstart == "0000-00-00") {
                 $arr = array("result" => "yes", "msg" => "Please Enter Issue Date");
            } else {
                if ($memex == "0000-00-00") {
                     $arr = array("result" => "yes", "msg" => "Please Enter Expire Date");
                } else {

                    $sql = "UPDATE `member` SET mem_code = '$memcode', mem_dateissue = '$memstart', mem_expried = '$memex', discount_id = '$memdiscount', mem_name = '$memname', mem_surname = '$memsurname', mem_add = '$memadd', mem_tel = '$memtell', mem_note = '$memremark', mem_status = '$memstatus' WHERE mem_id = '$memid' ";
                    $query = $database->executeStatement($sql);
                    if ($query) {
                        $arr = array("result" => "yes", "msg" => "no");
                    } else {
                        $arr = array("result" => "no");
                    }
                }
            }
        }
    }
}


echo json_encode($arr);
?>
