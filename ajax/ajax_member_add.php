<?php

include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();

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
if ($database->executeStatement_numrow("SELECT * FROM `member` WHERE `mem_code` = '$memcode' LIMIT 1 ") > 0) {
    $arr = array("result" => "yes", "msg" => "Member Code is duplicate");
} else {
    if (valid_array_string(array($memcode, $memstart, $memex, $memdiscount, $memname, $memsurname, $memadd, $memtell))) {

        $arr = array("result" => "yes", "msg" => "Make sure you have enter Member Code, Start, Expire, Name, Surname, Adress and tel");
    } else {
        if (!is_numeric($memtell)) {
            $arr = array("result" => "yes", "msg" => "Tel is only number");
        } else {
            
            if (trim($memstart) == "--") {
                $arr = array("result" => "yes", "msg" => "Please Enter Issue Date");
            } else {
                if (trim($memex) == "--") {
                    $arr = array("result" => "yes", "msg" => "Please Enter Expire Date");
                } else {
                 
                    $sql = "INSERT INTO `member` VALUES('','$memcode','$memstart','$memex','$memdiscount','$memname','$memsurname','$memadd','$memtell','$memremark','$memstatus')";
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
