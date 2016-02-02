<?php
include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$menu_item_id = mysql_real_escape_string($_REQUEST['menu_item_id']);
$sql = "SELECT menu.* , menu_category.menu_cate_name FROM menu INNER JOIN menu_category ON menu.menu_cate_id = menu_category.menu_cate_id    
WHERE menu_id = '$menu_item_id' ";
$menu_detail_arr = $database->executeSql($sql);
?>
<form role="form">
    <div class="form-group">
        <label>Menu</label>
        <input type="text" class="form-control" id="txt-menu-item" data-id="<?= $menu_detail_arr[0]->menu_id ?>" value="<?= $menu_detail_arr[0]->menu_name ?>">
        <label>Menu Category</label>
        <select class="form-control" id="txt-menu-item-cate">
            <?
            $menu_cate_arr = $database->executeSql("SELECT * FROM `menu_category` ORDER BY menu_cate_name ASC");
            ?>
            <option value="<?= $menu_detail_arr[0]->menu_cate_id ?>"><?= $menu_detail_arr[0]->menu_cate_name ?></opiton>
                <?
                foreach ($menu_cate_arr as $menu_cate_arr_val) {
                    if ($menu_detail_arr[0]->menu_cate_id != $menu_cate_arr_val->menu_cate_id) {
                        ?>
                    <option value="<?= $menu_cate_arr_val->menu_cate_id ?>"><?= $menu_cate_arr_val->menu_cate_name ?></opiton>
                        <?
                    }
                }
                ?>
        </select>
        <label>Price</label>
        <input type="text" class="form-control" id="txt-menu-item-price" value="<?= $menu_detail_arr[0]->menu_price ?>">
        <label>Picture</label>
        <div>
            <?
            $menu_img = "img_product/" . $menu_detail_arr[0]->menu_img;
            if ($menu_detail_arr[0]->menu_img == "") {
                $menu_img = "img_product/no_img.bmp";
            } elseif (!file_exists("../".$menu_img)) {
                $menu_img = "img_product/no_img.bmp";
            }
            ?>
            <img style="width: 80px;height: 80px;" src="<?= $menu_img ?>">
        </div>
        <br>
        <input type="file" id="txt-menu-item-file">
        <br>
        <label>Status:</label>
        <select class="form-control" id="txt-menu-item-status">
            <?
            if ($menu_detail_arr[0]->menu_status == 2) {
                ?>
                <option value="2">Enable</opiton>
                <option value="1">Disable</opiton>
                    <?
                } else {
                    ?>
                <option value="1">Disable</opiton>
                <option value="2">Enable</opiton>
                    <?
                }
                ?>
        </select> 
    </div>
</form>