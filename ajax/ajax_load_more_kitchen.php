<?php
include '../includes/config.inc.php';
// connect database 
$database = new Database();

$sql = "SELECT `order_detail`.*,`table_detail`.`table_name`, `menu`.menu_name, `user`.user_name FROM `order_detail` 
    INNER JOIN `order` ON `order_detail`.`order_id` = `order`.`order_id` 
    INNER JOIN `table_detail` ON `table_detail`.`table_id` = `order`.`table_id` 
    INNER JOIN `menu` ON `menu`.menu_id = `order_detail`.menu_id
        INNER JOIN `user` ON `user`.user_id = `order_detail`.user_id
    WHERE `order_detail_status` = '1' OR `order_detail_status` = '2'
    ORDER BY order_detail_id ASC ";
$order_detail_arr = $database->executeSql($sql);
?>
<tr style="background-color: #990000;color: white">

    <th>Menu</th>
    <th>Quantity</th>
    <th>Table</th>
    <th>Status</th>
    <th>User</th>
    <th>Datetime</th>
</tr>
<?
foreach ($order_detail_arr as $order_detail_value) {
    ?>
    <tr data-id="<?= $order_detail_value->order_detail_id ?>">
        <td><?= $order_detail_value->menu_name ?></td>
        <td><?= $order_detail_value->order_quantity ?></td>
        <td><?= $order_detail_value->table_name ?></td>
        <td>
            <?
            if ($order_detail_value->order_detail_status == '1') {
                echo '<button type="button" class="btn btn-danger btn-kitchen" data-id="cook">Cook</button>&nbsp;&nbsp;';
                echo '<button type="button" class="btn btn-default btn-kitchen" data-id="can_not_cook">Can\'t Cook</button>';
            } else if ($order_detail_value->order_detail_status == '2') {
                echo '<button type="button" class="btn btn-primary btn-kitchen" data-id="cook_finish">Finish</button>&nbsp;&nbsp;';
                echo '<button type="button" class="btn btn-default btn-kitchen" data-id="can_not_cook">Can\'t Cook</button>';
            }
            ?>
        </td>  
        <td><?= $order_detail_value->user_name ?></td>
        <td><?= $order_detail_value->order_detail_date ?></td>
    </tr>
    <?
}
?>
