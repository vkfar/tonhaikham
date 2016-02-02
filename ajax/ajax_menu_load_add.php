<?php
include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
?>
<form role="form">
    <div class="form-group">
        <label>Menu</label>
        <input type="text" class="form-control" id="txt-menu-item">
        <label>Menu Category</label>
        <select class="form-control" id="txt-menu-item-cate">
            <?
            $menu_cate_arr = $database->executeSql("SELECT * FROM `menu_category` ORDER BY menu_cate_name ASC");
            foreach ($menu_cate_arr as $menu_cate_arr_val) {
                ?>
                <option value="<?= $menu_cate_arr_val->menu_cate_id ?>"><?= $menu_cate_arr_val->menu_cate_name ?></opiton>
                    <?
                }
                ?>
        </select>
        <label>Price</label>
        <input type="text" class="form-control" id="txt-menu-item-price">
        <label>Picture</label>
        <br>
        <input type="file" id="txt-menu-item-file">
        <br>
        <label>Status:</label>
        <select class="form-control" id="txt-menu-item-status">
            <option value="2">Enable</opiton>
            <option value="1">Disable</opiton>
        </select> 
    </div>
</form>