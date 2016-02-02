<?php
require_once('includes/config.inc.php');

login_checker(array(1,2));


$database = new Database();
$database->openConnection();
$table_id_get = mysql_real_escape_string(trim($_REQUEST['table']));

$sql_order_detail = "SELECT `order`.discount_rate_due_order as discount , `order_detail`.*,  `table_detail`.table_name , `menu`.menu_name  FROM `order` 
INNER JOIN `table_detail` ON `table_detail`.`table_id` = `order`.`table_id` 
INNER JOIN (SELECT * FROM  `order_detail` WHERE `order_detail`.order_detail_status != '4' AND `order_detail`.order_detail_status != '6' ) as order_detail ON `order_detail`.`order_id` = `order`.`order_id` 
INNER JOIN `menu` ON `menu`.menu_id = `order_detail`.menu_id

WHERE `table_detail`.`table_id` = '$table_id_get' AND `order`.order_status = '0' ORDER BY `order_detail`.order_detail_id ASC ";


$order_detail_arr = $database->executeSql($sql_order_detail);
$bill_setting = $database->executeSql("SELECT * FROM `bill_setting` ");
$ordernum_id = $order_detail_arr[0]->order_id;

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Tonhaikham - Bill</title>
        <style type="text/css" media="all">
            #wrapper { width: 280px; margin: 0 auto; text-align:center; color:#000; font-family: Arial, Helvetica, sans-serif; font-size:12px; }
            #wrapper img { width: 80%; }
            h3 { margin: 5px 0; }
            .left { width:60%; float:left; text-align:left; margin-bottom: 3px; }
            .right { width:40%; float:right; text-align:right; margin-bottom: 3px; }
            .table, .totals { width: 100%; margin:10px 0; }
            .totals{margin-top: 10px; margin-bottom: 0px;}
            .table th { border-bottom: 1px solid #000; }
            .table td { padding:0; }
            .totals td { width: 24%; padding:0; }
            .table td:nth-child(2) { overflow:hidden; }
        </style>
        <style type="text/css" media="print">
            #buttons { display: none; }
        </style>
    </head>

    <body>
        <div id="wrapper">

            <h3><?= $bill_setting[0]->name ?></h3>
            <p style="text-transform:capitalize;"><?= $bill_setting[0]->address ?></p>
            <span class="left">Reference bill: <?= $ordernum_id ?></span> 
            <span class="right">Tel: <?= $bill_setting[0]->tell ?></span>
            <div style="clear:both;"></div>
            <span class="left"></span> 
            <span class="right">Date: 25-04-2014</span>    <div style="clear:both;"></div>

            <table class="table" cellspacing="0"  border="0"> 
                <thead> 
                    <tr> 
                        <th><em>#</em></th> 
                        <th>Description</th> 
                        <th>Qty</th>
                        <th>Price</th> 
                        <th>Total</th> 
                    </tr> 
                </thead> 
                <tbody> 
                    <?
                    $i = 1;
                    foreach ($order_detail_arr as $order_detail_value) {
                        ?>
                        <tr>
                            <td style="text-align:center; width:30px;"><?= $i ?></td>
                            <td style="text-align:left; width:180px;"><?= $order_detail_value->menu_name ?></td>
                            <td style="text-align:center; width:50px;"><?= $order_detail_value->order_quantity ?></td>
                            <td style="text-align:right; width:55px; "><?= number_format($order_detail_value->menu_price) ?></td>
                            <td style="text-align:right; width:65px;"><?= number_format($order_detail_value->menu_price*$order_detail_value->order_quantity) ?></td> 
                        </tr> 
                        <?
                        $qty = $qty + $order_detail_value->order_quantity;
                        $total = $total + ($order_detail_value->menu_price*$order_detail_value->order_quantity);
                        $i++;
                    }
                    $total_payable = $total;
                    if ($order_detail_value->discount > 0) {
                        $total_payable = $total_payable - ( $total_payable * ($order_detail_value->discount / 100));
                    }
                    ?>


                </tbody> 
            </table> 

            <table class="totals" cellspacing="0" border="0">
                <tbody>
                    <tr>
                        <td style="text-align:left;">Total menu</td>
                        <td style="text-align:right; padding-right:1.5%; border-right: 1px solid #999;font-weight:bold;"><?= number_format($qty) ?></td>
                        <td style="text-align:left; padding-left:1.5%;">Total</td><td style="text-align:right;font-weight:bold;"><?= number_format($total) ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:left;">Discount</td><td colspan="2" style="text-align:right;font-weight:bold;"><?= $order_detail_value->discount ?>%</td>
                    </tr>
                    <tr style="background-color: #cccccc">
                        <td colspan="2" style="text-align:left; font-weight:bold; border-top:1px solid #000; padding-top:5px;">Total Payable</td><td colspan="2" style="border-top:1px solid #000; padding-top:5px; text-align:right; font-weight:bold;"><?= number_format($total_payable) ?></td>
                    </tr>
                   
                </tbody>
            </table>
            <div id="buttons" style="padding-top:10px; text-transform:uppercase;">
                <span class="right"><button type="button" onClick="window.print();
                        return false;" style="width:80%; cursor:pointer; font-size:12px; background-color:#FFA93C; color:#000; text-align: center; border:1px solid #FFA93C; padding: 10px 1px; border-radius:5px;">Print</button></span>
                <div style="clear:both;"></div>
            </div>
        </div>
    </body>
</html>
