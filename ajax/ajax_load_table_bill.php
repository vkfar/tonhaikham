<?php
include '../includes/config.inc.php';

$sys_user = $_SESSION["sess_user"];
$sys_user_id = $_SESSION["sess_user_id"];
$sys_user_role = $_SESSION["sess_user_role"];
// connect database 
$database = new Database();
$table_id = mysql_real_escape_string($_REQUEST['table']);
$sql_table = "SELECT * FROM `table_detail` WHERE table_id = '$table_id' LIMIT 1";
$table_detail = $database->executeSql($sql_table);

//booking table bill
if ($table_detail[0]->tb_status_id == "3") {
    $sql_reserve = "SELECT * FROM reservation WHERE `table_id` = '$table_id' AND reserve_status='1' ";
    $reserve_detail = $database->executeSql($sql_reserve);
    $user_book_id = $reserve_detail[0]->user_id;
    $user_book = $database->executeSql("SELECT * FROM user WHERE user_id ='$user_book_id' ");
    ?>
    <ol class="breadcrumb">
        <li><a href="service.php">Service</a></li>
        <li><a href="order.php">Order</a></li>
        <li><a class="btn_load_new_table_again"><?= $table_detail[0]->table_name ?></a></li>
    </ol>
    <div style="background-color: #ffff99;text-align: left;padding: 10px;border-radius: 5px;padding-left: 50px;">
    <p><h3><span class="glyphicon glyphicon-bookmark"></span> Reservation Detail</h3></p>
    <input type="hidden" class="txt_reservation_id" value="<?= $reserve_detail[0]->reserve_id ?>">
    <p><b>User :</b> <?= $user_book[0]->user_name ?></p>
    <p><b>Customer Name:</b> <?= $reserve_detail[0]->reserve_name ?></p>
    <p><b>Customer Tel:</b> <?= $reserve_detail[0]->reserve_tel ?></p>
    <p><b>Date:</b> <?= mysql_string_date_time($reserve_detail[0]->reserve_date_add) ?></p>
    <p><b>Reservation on</b> : <?= mysql_string_date_time($reserve_detail[0]->reserve_on_date) ?></p>
    <p><b>Note</b> : <?= trim($reserve_detail[0]->reserve_note) ?></p>
    <?
    if (in_array($sys_user_role, array(1, 2))) {
        ?>


        <button class="btn btn-success btn-reservation-confirm">Confirm</button>
        <button class="btn btn-warning btn-reservation-cancle">Cancel</button>
        <button class="btn btn-primary btn-reservation-edit" data-target="#this_modal" data-toggle="modal">Edit</button>
        <button class="btn btn-danger btn-reservation-del">Delete</button>

        <?
    }
    ?>

    </div>
    <?
} else {

    $sql_order = "SELECT * FROM `order` WHERE `table_id` = '$table_id' AND order_status = '0'  LIMIT 1";
    $order = $database->executeSql($sql_order);
    if (count($order) > 0) {

        $sql_order_detail = " SELECT `order_detail`.* , `menu`.menu_name FROM `order_detail` INNER JOIN menu ON `menu`.menu_id = `order_detail`.menu_id  WHERE `order_id` = '" . $order[0]->order_id . "' AND `order_detail_status` != '6'  ORDER BY order_detail_id DESC ";
        $order_detail = $database->executeSql($sql_order_detail);
        if (count($order_detail) != 0) {
            ?>
            <div>
                <div class="col-sm-9">
                    <ol class="breadcrumb">
                        <li><a href="service.php">Service</a></li>
                        <li><a href="order.php">Order</a></li>
                        <li><a class="btn_load_new_table_again"><?= $table_detail[0]->table_name ?></a></li>
                    </ol>

                </div>
                <div class="col-sm-3"> <div><button class="btn-sm btn-danger btn_chg_table" style="border-radius: 0px;">Move Table</button></div> </div>
                <div class="clearfix"></div>
            </div>


            <div style="overflow-y: scroll;height: 330px;border: 1px solid #990000" class="table-responsive">
                <table class="table" id="table_bill">
                    <tr style="background-color: #990000;color: white;text-align: center">
                        <th>#</th>
                        <th>Menu</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                    <?
                    $i = count($order_detail);
                    $btn_confirm = FALSE;
                    foreach ($order_detail as $order_detail_value) {
//                    echo "<pre>";
//                    var_dump($order_detail_value);
//                    echo "</pre>";
                        $trcolor = "";
                        $item_q_f = "";
                        $item_q_s = "";
                        $more_price = true;
                        if ($order_detail_value->order_detail_status == 0) {
                            $status = "<span class='glyphicon glyphicon-trash remove_item'>&nbsp;&nbsp;</span>";
                            $btn_confirm = true;
                            $item_q_f = '<div class="item_q" data-toggle="modal" data-target="#this_modal">';
                            $item_q_s = "</div>";
                        } else if ($order_detail_value->order_detail_status == 1) {
                            $trcolor = "danger";
                            $status = "waiting";
                        } else if ($order_detail_value->order_detail_status == 2) {
                            $trcolor = "warning";
                            $status = "cooking";
                        } else if ($order_detail_value->order_detail_status == 3) {
                            $status = "cook";
                        } else if ($order_detail_value->order_detail_status == 4) {
                            $status = "can't cook";
                            $more_price = FALSE;
                        } else if ($order_detail_value->order_detail_status == 5) {
                            $trcolor = "success";
                            $status = "served";
                        }
                        ?>
                        <tr class=" <?= $trcolor ?>" data-id="<?= $order_detail_value->order_detail_id ?>">
                            <td><?= $i ?></td>
                            <td><?= $order_detail_value->menu_name ?></td>
                            <td style="text-align: center"><?= $item_q_f . $order_detail_value->order_quantity . $item_q_s ?></td>
                            <td style="text-align: right"><?= number_format(($order_detail_value->menu_price)) ?></td>
                            <td style="text-align: right"><?= number_format(($order_detail_value->menu_price*$order_detail_value->order_quantity)) ?></td>
                            <td style="text-align: center"><?= $status ?></td>
                        </tr>
                        <?
                        $i--;
                        if ($more_price) {
                            $total_price = $total_price + ($order_detail_value->menu_price*$order_detail_value->order_quantity);
                        }
                    }
                    ?>


                </table>

            </div>

            <table class="table">
                <tr style="background-color: #990000;color: white">
                    <td colspan="5"><b>Total</b></td>
                    <td style="text-align: right"><b><?= number_format($total_price) ?></b></td>
                    <td><b>Kip</b></td>
                </tr>
                <?
                if ($order[0]->mem_id != 0 AND $order[0]->discount_rate_due_order != 0) {
                    ?>
                    <tr style="background-color: #990000;color: white">
                        <td colspan="5"><b>Discount <?= $order[0]->discount_rate_due_order ?> %</b></td>
                        <td style="text-align: right"><b><?= number_format($total_price * ($order[0]->discount_rate_due_order / 100)) ?></b></td>
                        <td><b>Kip</b></td>
                    </tr>
                    <tr style="background-color: #990000;color: white">
                        <td colspan="5"><b>Total</b></td>
                        <td style="text-align: right"><b><?= number_format($total_price - ($total_price * ($order[0]->discount_rate_due_order / 100))) ?></b></td>
                        <td><b>Kip</b></td>
                    </tr>
                    <?
                }
                ?>
            </table>
            <div style="text-align: center"> 

                <?
                if (in_array($sys_user_role, array(1, 2))) {

                    // show btn payment if no order
                    if (!$btn_confirm) {
                        echo '<button class="btn btn-primary" id="btn-printbill">Print</button> <button class="btn btn-success" id="btn-payment" data-toggle="modal" data-target="#this_modal">Payment</button> ';
                        if ($order[0]->mem_id != 0 AND $order[0]->discount_rate_due_order != 0) {
                            echo '<button class="btn btn-danger btn_remove_verify">Remove Verify</button>';
                        } else {
                            echo '<button class="btn btn-default btn_member_verify" data-toggle="modal" data-target="#this_modal">Member Verify</button>';
                        }
                    }
                }
                // show btn confrim
                if ($btn_confirm) {
                    echo '<button class="btn btn-warning" id="btn-confirm-order">confirm</button>';
                }
                ?>

                <br><br>


            </div>

            <?
        } else {
            ?>
            <ol class="breadcrumb">
                <li><a href="service.php">Service</a></li>
                <li><a href="order.php">Order</a></li>
                <li><a class="btn_load_new_table_again"><?= $table_detail[0]->table_name ?></a></li>
            </ol>
            <div style="text-align: center">
                <div>
                    <p><b>Can't cook all order</b></p>
                    <button class="btn btn-danger btn_cancle_table" >Cancel</button><br><br><button class="btn btn-default btn_chg_table" >Change Table</button> 
                </div>
            </div>
            <?
        }
    } else {
// book ing button
        ?>
        <ol class="breadcrumb">
            <li><a href="service.php">Service</a></li>
            <li><a href="order.php">Order</a></li>
            <li><a class="btn_load_new_table_again"><?= $table_detail[0]->table_name ?></a></li>
        </ol>
        <div style="text-align: center;padding: 15px;">
            <?
            if (in_array($sys_user_role, array(1, 2))) {
                ?>
                <button class="btn btn-warning btn_load_reservation_new" data-toggle="modal" data-target="#this_modal" >
                    Reservation table
                </button>
                <?
            }
            ?>
        </div>

        <?
    }
}
?>
