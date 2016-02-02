<?php

function mysql_date_to_string($str) {
    $str_arr = explode('-', $str);
    return $str_arr[2] . "-" . $str_arr[1] . "-" . $str_arr[0];
}

function convert_date_to_mysql($str) {
   $str_arr = explode('-', $str);
   return $str_arr[2]."-".$str_arr[1]."-".$str_arr[0];
}

function mysql_string_date_time($str) {
    $date = new DateTime($str);
    return $date->format('d-m-Y H:i');
}
function mysql_convert_string_to_date_time($str) {
    $date = new DateTime($str);
    return $date->format('Y-m-d H:i');
}

function user_role($str) {
    $role[1] = "Owner";
    $role[2] = "Cashier";
    $role[3] = "Cook";
    $role[4] = "Waiter";
    return $role[$str];
}

function status_num_to_string($str) {
    $status[1] = "Disable";
    $status[2] = "Enable";
    return $status[$str];
}

function login_checker_index() {
    if (isset($_SESSION['sess_user_id']) && isset($_SESSION['sess_user']) && isset($_SESSION['sess_user_role'])) {
        // Nothing
        header("location:backoffice.php");
    }
}

function login_checker($role = array()) {
    if (isset($_SESSION['sess_user_id']) && isset($_SESSION['sess_user']) && isset($_SESSION['sess_user_role'])) {
        if(!in_array($_SESSION['sess_user_role'], $role)){
              header("location:index.php");
        }
    } else {
        header("location:index.php");
    }
}

function valid_array_string($string_arr = array()) {
    foreach ($string_arr as $value) {
       if(trim($value) == ""){
            return TRUE;
       } 
    }
    return FALSE;
}
