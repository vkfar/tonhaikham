<?php
include '../includes/config.inc.php';
// connect database 
$database = new Database();
$table_id = mysql_real_escape_string($_REQUEST['table']);
$sql_table = "SELECT  `order`.`order_id`, `order`.discount_rate_due_order as ds, `table_detail`.`table_name`, sum(menu_price * order_quantity) as total, sum(order_quantity) as quantity FROM `order` 
INNER JOIN `table_detail` ON `table_detail`.`table_id` = `order`.`table_id` 
INNER JOIN (SELECT * FROM  `order_detail` WHERE `order_detail`.order_detail_status != '4' AND `order_detail`.order_detail_status != '6' ) as order_detail ON `order_detail`.`order_id` = `order`.`order_id` 
WHERE `order`.`table_id` = '$table_id' AND `order`.order_status = '0' GROUP BY table_name ";
$table = $database->executeSql($sql_table);
?>
<form role="form">
    <div class="form-group">
        <label>Total Payable:</label>
        <input type="hidden" id="ordernum_id" value="<?= $table[0]->order_id ?>">
        <label class="form-control" style="background-color: #ffffcc"><?= number_format($table[0]->total - ($table[0]->total * ($table[0]->ds / 100))) ?></label>
        <input type="hidden" class="form-control" id="txt-total-order" value="<?= ($table[0]->total - ($table[0]->total * ($table[0]->ds / 100))) ?>" disabled="">
        <label>Total Item:</label>
        <label class="form-control" style="background-color: #ffffcc"><?= number_format($table[0]->quantity) ?></label>
        <label>Paid</label>
        <input type="text" id="txt-total-paid" class="form-control" value="">
        <label>Change</label>
        <label class="form-control" id="txt-chage" style="background-color: #ffcccc"></label>
  
    </div>
</form>
