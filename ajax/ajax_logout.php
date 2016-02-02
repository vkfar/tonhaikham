<?php
include '../includes/config.inc.php';
if(session_destroy()){
    $arr = array("result"=>"yes");
}else{
    $arr = array("result"=>"Logout Error");
}
echo json_encode($arr);
?>
