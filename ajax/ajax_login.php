<?php

include '../includes/config.inc.php';
// connect database 
$database = new Database();
$user = mysql_real_escape_string($_REQUEST['user']);
$pass = mysql_real_escape_string($_REQUEST['pass']);
$user_arr = $database->executeSql("SELECT * FROM user WHERE user ='$user' AND user_password ='$pass' ");
if (count($user_arr) == 1) {
    if ($user_arr[0]->user_status == "2") {
        $_SESSION['sess_user_id'] = $user_arr[0]->user_id;
        $_SESSION['sess_user'] = $user_arr[0]->user;
        $_SESSION['sess_user_role'] = $user_arr[0]->user_role;
        $return_json = array("result" => "yes");
    } else {
        $return_json = array("result" => "This user is disable!");
    }
} else if (count($user_arr) == 0) {
    $return_json = array("result" => "User or Password Incorrect");
} else {
    $return_json = array("result" => "Login ERROR!");
}
echo json_encode($return_json);
?>
