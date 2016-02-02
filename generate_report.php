<?php

require_once('includes/config.inc.php');
require_once ('./tcpdf/tcpdf.php');

$database = new Database();
$database->openConnection();
$html = "";
$generate_type = mysql_real_escape_string($_REQUEST["type"]);
$generate_type_arr[1] = "Report Income From " . $_REQUEST["s"] . " To " . $_REQUEST["e"];
$generate_type_arr[2] = "Report Popultar Menu From " . $_REQUEST["s"] . " To " . $_REQUEST["e"];
$generate_type_arr[3] = "Report Menu Can't Cook From " . $_REQUEST["s"] . " To " . $_REQUEST["e"];
$generate_type_arr[4] = "Menu ";
$generate_type_arr[5] = "Report Table Reservation From " . $_REQUEST["s"] . " To " . $_REQUEST["e"];
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
$pdf->SetHeaderData('', 0, PDF_HEADER_TITLE, " " . $generate_type_arr[$generate_type]);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->AddPage();
$d_start = mysql_real_escape_string(convert_date_to_mysql($_REQUEST['s']));
$d_end = mysql_real_escape_string(convert_date_to_mysql($_REQUEST['e']));
// income
if ($generate_type == 1) {

    $sql = "SELECT `order`. * , `user`.user_name , date(order_date) as new_date 
FROM `order`
INNER JOIN `user` ON `user`.user_id = `order`.user_id 
WHERE `order`.user_id != '0' AND `order_status` = '1' AND date(order_date) BETWEEN '" . $d_start . "' AND '" . $d_end . "'  ORDER BY order_date ASC ";
    $order_arr = $database->executeSql($sql);
    $date_old = $order_arr[0]->new_date;

    if ($_REQUEST['bill'] != "enable") {
        $html .= '<table cellpadding="1" cellspacing="1" border="1" width="100%">';
        $html .= '<tr bgcolor="#C7C7C7"><th  width="70"> Date</th><th> Income</th><th> Bill</th><th> Order</th></tr>';
        foreach ($order_arr as $order_val) {
            $sql_detail = "SELECT `order_detail`.* , `menu`.menu_name , `user`.user_name FROM order_detail 
            INNER JOIN `menu` ON `menu`.menu_id = `order_detail`.menu_id 
            INNER JOIN `user` ON `user`.user_id = `order_detail`.`user_id`
            WHERE `order_detail`.order_id = '" . $order_val->order_id . "' AND `order_detail`.order_detail_status = '5' ";
            $detail_arr = $database->executeSql($sql_detail);
            $num = 0;
            $price = 0;
            foreach ($detail_arr as $detail_arr_val) {
                $price = $price + ($detail_arr_val->menu_price*$detail_arr_val->order_quantity);
                $num += $detail_arr_val->order_quantity;
            }
            $total_payable_of = $total_payable_of + ($price - ($price * ($order_val->discount_rate_due_order / 100)));
            $total_bill++;
            $total_order = $num + $total_order;

            $i++;
            if ($order_arr[$i]->new_date != $date_old) {
                $html .= '<tr style="text-align:right"><td> ' . mysql_date_to_string($order_val->new_date) . ' </td><td> ' . number_format($total_payable_of) . ' </td><td> ' . number_format($total_bill) . '</td><td> ' . number_format($total_order) . ' </td></tr>';
                $date_old = $order_arr[$i]->new_date;
                $all_total_payable_of = $all_total_payable_of + $total_payable_of;
                $all_total_order = $all_total_order + $total_order;
                $all_total_bill = $all_total_bill + $total_bill;
                $total_payable_of = 0;
                $total_order = 0;
                $total_bill = 0;
            }
        }
        $html .= '</table>';
    } else {

        foreach ($order_arr as $order_val) {

            $sql_detail = "SELECT `order_detail`.* , `menu`.menu_name , `user`.user_name FROM order_detail 
            INNER JOIN `menu` ON `menu`.menu_id = `order_detail`.menu_id 
            INNER JOIN `user` ON `user`.user_id = `order_detail`.`user_id`
            WHERE `order_detail`.order_id = '" . $order_val->order_id . "' AND `order_detail`.order_detail_status = '5' ";
            $detail_arr = $database->executeSql($sql_detail);

            $html .= '<table cellpadding="1" cellspacing="1" border="1" width="100%">';
            $num = 0;
            $price = 0;
            $html .= '<tr bgcolor="blue" style="color:white"><td colspan="5" >Bill: ' . $order_val->order_id . '</td><td style="text-align:center">' . $order_val->user_name . '</td></tr>';
            foreach ($detail_arr as $detail_arr_val) {
                $html .= '<tr><td width="27" style="text-align:right">' . $detail_arr_val->menu_id . '</td><td width="138">' . $detail_arr_val->menu_name . '</td><td width="36" style="text-align:right">' . number_format($detail_arr_val->order_quantity) . '</td><td style="text-align:right">' . number_format($detail_arr_val->menu_price*$detail_arr_val->order_quantity) . '</td><td width="135" style="text-align:center">' . mysql_string_date_time($detail_arr_val->order_detail_date) . '</td><td style="text-align:center">' . $detail_arr_val->user_name . '</td></tr>';
                $price = $price + ($detail_arr_val->menu_price * $detail_arr_val->order_quantity);
                $num += $detail_arr_val->order_quantity;
            }
            $html .= '<tr><td colspan="2">Total</td><td style="text-align:right">' . number_format($num) . '</td><td colspan="3" style="text-align:right">' . number_format($price) . '</td></tr>';
            $html .= '<tr><td colspan="2">Discount</td><td style="text-align:right">' . $order_val->discount_rate_due_order . '%</td><td colspan="3" style="text-align:right">' . number_format($price * ($order_val->discount_rate_due_order / 100)) . '</td></tr>';

            $total_payable_of = $total_payable_of + ($price - ($price * ($order_val->discount_rate_due_order / 100)));
            $total_bill++;
            $total_order = $num + $total_order;
            $html .= '<tr><td colspan="3">Total Payable</td><td colspan="3" style="text-align:right">' . number_format($price - ($price * ($order_val->discount_rate_due_order / 100))) . '</td></tr>';
            $html .= '</table>';

            $i++;
            if ($order_arr[$i]->new_date != $date_old) {
                $html .= '<table cellpadding="1" cellspacing="1" border="1" width="100%"><tr bgcolor="#C7C7C7"><td> ' . mysql_date_to_string($order_val->new_date) . '</td><td> Income : ' . number_format($total_payable_of) . '</td><td> bill : ' . $total_bill . '</td><td> order : ' . $total_order . '</td></tr></table>';
                $date_old = $order_arr[$i]->new_date;
                $all_total_payable_of = $all_total_payable_of + $total_payable_of;
                $all_total_order = $all_total_order + $total_order;
                $all_total_bill = $all_total_bill + $total_bill;
                $total_payable_of = 0;
                $total_order = 0;
                $total_bill = 0;
            }
        }
    }
    $html .= "<div><hr><br><p>Total Income : " . number_format($all_total_payable_of) . "<br>Total bill : " . $all_total_bill . "<br>Total order : " . $all_total_order . "</p></div>";
} else if ($generate_type == 2) {
    $num_list = mysql_real_escape_string($_REQUEST['num']);
    $num_list = ($num_list == "" ? 0 : $num_list);
    $sql = "SELECT order_detail.menu_id , SUM(order_quantity) AS total_q, SUM(order_quantity*order_detail.menu_price) AS total_price , menu.menu_name FROM `order_detail` 
            INNER JOIN `menu` ON `order_detail`.menu_id = `menu`.menu_id
            WHERE `order_detail`.order_detail_status = '5' AND 
            date(order_detail_date) BETWEEN '" . $d_start . "' AND '" . $d_end . "'
            group by order_detail.menu_id ORDER BY total_q " . mysql_real_escape_string($_REQUEST['order']) . " LIMIT " . $num_list;

    $pop_detail_arr = $database->executeSql($sql);
    if (count($pop_detail_arr) > 0) {
        $i = 1;
        $html .= '<table cellpadding="1" cellspacing="1" border="1" width="100%">';
        $html .= '<tr bgcolor="#C7C7C7" style="text-align:center"><th width="35"> #</th><th width="55"> Menu ID</th><th width="155"> Menu</th><th> Sold Quantity</th><th> Income</th></tr>';
        foreach ($pop_detail_arr as $pop_detail_val) {
            $html .= '<tr style="text-align:right"><td>' . $i . '</td><td> ' . $pop_detail_val->menu_id . '</td><td style="text-align:left"> ' . $pop_detail_val->menu_name . '</td><td> ' . $pop_detail_val->total_q . '</td><td> ' . number_format($pop_detail_val->total_price) . '</td></tr>';
            $i++;
            $total_income = $total_income + $pop_detail_val->total_price;
            $total_sold = $total_sold + $pop_detail_val->total_q;
        }
        $html .= '</table>';
        $html .= '<br><br><hr><br><br><br>';
        $html .= '<div><p>Total Sold Quantity : ' . number_format($total_sold) . ' <br>Total Income : ' . number_format($total_income) . '</p></div>';
    } else {
        $html .= "<div>No Info</div>";
    }
} else if ($generate_type == 3) {
    $sql = "SELECT `order_detail`.* , table_detail.table_name, menu.menu_name  FROM `order` 
        INNER JOIN `order_detail` ON `order_detail`.order_id = `order`.order_id
        INNER JOIN `table_detail` ON `table_detail`.table_id = `order`.table_id
        INNER JOIN `menu` ON `order_detail`.menu_id = `menu`.menu_id
        WHERE `order_detail`.order_detail_status = '6' AND date(order_detail_date) BETWEEN '" . $d_start . "' AND '" . $d_end . "' 
        ORDER BY order_detail_date ASC
        ";
    $not_cook_detail_arr = $database->executeSql($sql);
    if (count($not_cook_detail_arr) > 0) {
        $i = 1;
        $html .= '<table cellpadding="1" cellspacing="1" border="1" width="100%">';
        $html .= '<tr bgcolor="#C7C7C7" style="text-align:center"><th width="25"> #</th><th width="45">Bill</th><th width="45"> Menu ID</th><th width="125"> Menu</th><th width="50">Quantity</th><th>Price</th><th width="40">Table</th><th width="108">Datetime</th></tr>';
        foreach ($not_cook_detail_arr as $not_cook_detail_val) {
            $html .= '<tr style="text-align:right"><td>' . $i . '</td><td> ' . $not_cook_detail_val->order_id . '</td><td> ' . $not_cook_detail_val->menu_id . '</td><td style="text-align:left"> ' . $not_cook_detail_val->menu_name . '</td><td> ' . $not_cook_detail_val->order_quantity . '</td><td> ' . number_format($not_cook_detail_val->menu_price * $not_cook_detail_val->order_quantity) . '</td><td> ' . $not_cook_detail_val->table_name . '</td><td> ' . mysql_string_date_time($not_cook_detail_val->order_detail_date) . '</td></tr>';
            $i++;
            $total_price = $total_price + ($not_cook_detail_val->menu_price * $not_cook_detail_val->order_quantity);
            $total_q = $total_q + $not_cook_detail_val->order_quantity;
        }
        $html .= '</table>';
        $html .= '<br><br><hr><br><br><br>';
        $html .= '<div><p>Total Quantity : ' . number_format($total_q) . ' <br>Total Price : ' . number_format($total_price) . '</p></div>';
    } else {
            $html .= "<div>No Info</div>";
    }
} else if ($generate_type == 4) {

    $menu_cate = mysql_real_escape_string($_REQUEST['menu_cate']);
    $list_menu_status = mysql_real_escape_string($_REQUEST['list_menu_status']);
    $show_img = mysql_real_escape_string($_REQUEST['show_img']);

    $list_menu_type = mysql_real_escape_string($_REQUEST['list_menu_type']);
    $list_menu_order = mysql_real_escape_string($_REQUEST['list_menu_order']);


    //condition
    $sql_choose_status = ($list_menu_status == "" ? $list_menu_status : " AND `menu`.menu_status = '$list_menu_status' ");
    $sql_order_by = "ORDER BY " . $list_menu_type . " " . $list_menu_order;

    $sql = "SELECT * FROM `menu_category` WHERE `menu_category`.menu_cate_id IN (" . $menu_cate . ") ORDER BY menu_cate_name ASC ";
    $menu_cate_arr = $database->executeSql($sql);
    $col_2 = "340";
    foreach ($menu_cate_arr as $menu_cate_val) {

        $sql = "SELECT * FROM `menu` WHERE `menu_cate_id` = '" . $menu_cate_val->menu_cate_id . "' " . $sql_choose_status . " " . $sql_order_by;
        $menu_arr = $database->executeSql($sql);
        if (count($menu_arr) > 0) {
            $html .= '<h3>' . $menu_cate_val->menu_cate_name . '</h3>';
            $html .= '<table cellpadding="1" cellspacing="1"  width="100%">';
        }


        foreach ($menu_arr as $menu_arr_val) {
            if ($show_img == 'Enable') {
                $col_2 = "215";
            }
            $html .= '<tr style="text-align:right;" bgcolor="#EEEEEE"><td width="50"> ' . $menu_arr_val->menu_id . '</td><td style="text-align:left" width="' . $col_2 . '"> ' . $menu_arr_val->menu_name . '</td>';
            if ($show_img == 'Enable') {
                if ($menu_arr_val->menu_img != "") {
                    $html .= '<td width="120" style="text-align:center"><p><br><img src="img_product/' . $menu_arr_val->menu_img . '" height="80" width="100"></p></td>';
                } else {
                    $html .= '<td width="120" ></td>';
                }
            }
            $html .= '<td width="120"> ' . number_format($menu_arr_val->menu_price) . '</td></tr>';
        }
        if (count($menu_arr) > 0) {
            $html .= '</table>';
        }
    }
    
    
}else if($generate_type == 5){
    
    $reserve_status = mysql_real_escape_string($_REQUEST['reservation']);
     $sql = "SELECT `reservation`.* , table_detail.table_name, user.user_name  FROM `reservation` 
        INNER JOIN `user` ON `user`.user_id = `reservation`.user_id
        INNER JOIN `table_detail` ON `table_detail`.table_id = `reservation`.table_id
        WHERE `reservation`.reserve_status IN ($reserve_status) AND date(reserve_on_date) BETWEEN '" . $d_start . "' AND '" . $d_end . "' 
        ORDER BY reserve_on_date ASC
        ";
    $reserve_arr = $database->executeSql($sql);
    if (count($reserve_arr) > 0) {
        $reserve_status_arr[1] = "Current";
        $reserve_status_arr[2] = "Confirm";
        $reserve_status_arr[3] = "Cancle";
        $i = 1;
        $html .= '<table cellpadding="1" cellspacing="1" border="1" width="100%">';
        $html .= '<tr bgcolor="#C7C7C7" style="text-align:center"><th width="20"> #</th><th width="42">Table</th><th width="60"> Customer</th><th width="60"> Tel</th><th width="105">Date</th><th width="105">Date <br>Reservation</th><th width="40">User</th><th width="40">Note</th><th width="50">Status</th></tr>';
        foreach ($reserve_arr as $reserve_val) {
            $html .= '<tr style="text-align:right"><td>' . $i . '</td><td style="text-align:center"> ' . $reserve_val->table_name . '</td><td style="text-align:left"> ' . $reserve_val->reserve_name . '</td><td style="text-align:left"> ' . $reserve_val->reserve_tel . '</td><td style="text-align:left"> ' . mysql_string_date_time($reserve_val->reserve_date_add) . '</td><td> ' . mysql_string_date_time($reserve_val->reserve_on_date) . '</td><td style="text-align:left"> ' . $reserve_val->user_name . '</td><td> ' . $reserve_val->reserve_note . '</td><td style="text-align:center"> ' . $reserve_status_arr[$reserve_val->reserve_status] . '</td></tr>';
            $i++;

        }
        $html .= '</table>';
    } else {
            $html .= "<div>No Info</div>";
    }
    
    
    
}


//echo $html;
$pdf->writeHTML($html, true, false, true, false, '');
$name_pdf = md5(uniqid());
$pdf->Output($name_pdf, 'I');
?>
