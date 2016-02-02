<?php
include '../includes/config.inc.php';
// connect database 
$database = new Database();

$sql = "SELECT `order_detail`.*,`table_detail`.`table_name`, `menu`.menu_name,  `user`.user_name FROM `order_detail` 
    INNER JOIN `order` ON `order_detail`.`order_id` = `order`.`order_id` 
    INNER JOIN `table_detail` ON `table_detail`.`table_id` = `order`.`table_id` 
    INNER JOIN `menu` ON `menu`.menu_id = `order_detail`.menu_id
       INNER JOIN `user` ON `user`.user_id = `order_detail`.user_id
    WHERE `order_detail_status` = '3' OR `order_detail_status` = '4' 
    ORDER BY order_detail_id ASC ";
$order_detail_arr = $database->executeSql($sql);
?>
<tr style="background-color: #990000;color: white">

    <th>Menu</th>
    <th>Quantity</th>
    <th>Table</th>
    <th>Status</th>
      <th>&nbsp;</th>
    <th>User</th>
    <th>Datetime</th>
</tr>
<?
foreach ($order_detail_arr as $order_detail_value) {
    $tr_color = "";
    if ($order_detail_value->order_detail_status == '3') {
//                            $tr_color = "class='success' ";
    } else if ($order_detail_value->order_detail_status == '4') {
        $tr_color = "class='danger' ";
    }
    ?>
    <tr <?= $tr_color ?> data-id="<?= $order_detail_value->order_detail_id ?>">
        <td><?= $order_detail_value->menu_name ?></td>
        <td><?= $order_detail_value->order_quantity ?></td>
        <td><?= $order_detail_value->table_name ?></td>
        <td>
            <?
            if ($order_detail_value->order_detail_status == '3') {
                echo "Finish";
            } else if ($order_detail_value->order_detail_status == '4') {
                echo "Can't Cook";
            }
            ?>
        </td>
        <td>
            <?
            if ($order_detail_value->order_detail_status == '3') {
                echo '<button type="button" class="btn btn-primary btn-serve" data-id="cook_finish_serve">Serve</button>';
            } else if ($order_detail_value->order_detail_status == '4') {
                echo '<button type="button" class="btn btn-danger btn-serve" data-id="can_not_cook_serve">Tell Customer</button>';
            }
            ?>

        </td>
        
        <td><?= $order_detail_value->user_name ?></td>
        <td><?= $order_detail_value->order_detail_date ?></td>
    </tr>
    <?
}
?>

