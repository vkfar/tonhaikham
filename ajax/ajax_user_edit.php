<?php

include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$user_id = mysql_real_escape_string($_REQUEST["user_id"]);
$user = mysql_real_escape_string(trim($_REQUEST["user"]));
$pass = mysql_real_escape_string(trim($_REQUEST["pass"]));
$name = mysql_real_escape_string(trim($_REQUEST["name"]));
$surname = mysql_real_escape_string(trim($_REQUEST["surname"]));
$address = mysql_real_escape_string($_REQUEST["address"]);
$tell = mysql_real_escape_string($_REQUEST["tell"]);
$role = mysql_real_escape_string($_REQUEST["role"]);
$info = mysql_real_escape_string($_REQUEST["info"]);
$user_status = mysql_real_escape_string($_REQUEST["user_status"]);

if ($database->executeStatement_numrow("SELECT * FROM `user` WHERE `user` = '$user' AND `user_id` != '$user_id' LIMIT 1 ") > 0) {
    $arr = array("result" => "yes", "msg" => "Username is duplicate");
} else {
    if (valid_array_string(array($user, $pass, $name, $surname))) {
        $arr = array("result" => "yes", "msg" => "Please Enter Password, Name, Surname");
    } else {
        $sql = "UPDATE `user` SET user = '$user', user_password = '$pass', user_name = '$name', user_surname = '$surname', user_add = '$address', user_tel = '$tell', user_role = '$role', user_more_info = '$info', user_status = '$user_status' WHERE `user_id` = '$user_id' ";
        $query = $database->executeStatement($sql);
        if ($query) {
            $arr = array("result" => "yes", "msg" => "no");
        } else {
            $arr = array("result" => "no");
        }
    }
}
echo json_encode($arr);
?>
