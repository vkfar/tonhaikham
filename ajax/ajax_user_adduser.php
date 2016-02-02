<?php

include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();

$user = mysql_real_escape_string($_REQUEST["user"]);
$pass = mysql_real_escape_string($_REQUEST["pass"]);
$name = mysql_real_escape_string($_REQUEST["name"]);
$surname = mysql_real_escape_string($_REQUEST["surname"]);
$address = mysql_real_escape_string($_REQUEST["address"]);
$tell = mysql_real_escape_string($_REQUEST["tell"]);
$role = mysql_real_escape_string($_REQUEST["role"]);
$info = mysql_real_escape_string($_REQUEST["info"]);
$user_status = mysql_real_escape_string($_REQUEST["user_status"]);



if ($database->executeStatement_numrow("SELECT * FROM `user` WHERE `user` = '$user' LIMIT 1 ") > 0) {
    $arr = array("result" => "yes", "msg" => "Username is duplicate");
} else {

    if (valid_array_string(array($user, $pass, $name, $surname))) {
        $arr = array("result" => "yes", "msg" => "Please Enter Password, Name, Surname");
    } else {
        $sql = "INSERT INTO `user` VALUES('','$user','$pass','$name','$surname','$address','$tell','$role','$info','$user_status')";
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
