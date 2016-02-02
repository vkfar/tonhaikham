<?php
include '../includes/config.inc.php';

// connect database 
$database = new Database();
$database->openConnection();
$menu = mysql_real_escape_string(trim($_REQUEST['menu']));
$type_search = mysql_real_escape_string(trim($_REQUEST['menu_type']));

$type_search_arr['ID'] = "WHERE `menu`.menu_id LIKE '%$menu%' ";
$type_search_arr['Menu'] = "WHERE `menu`.menu_name LIKE '%$menu%' ";
$type_search_arr['Price'] = "WHERE `menu`.menu_price LIKE '%$menu%' ";
$type_search_arr['Status'] = "WHERE `menu`.menu_status LIKE '%$menu%' ";
$type_search_arr['defualt'] = "WHERE menu_cate_id='$menu' ";

if($type_search == ""){
    $type_search = "defualt";
}

if ($menu != "") {

    $sql = "SELECT * FROM menu ".$type_search_arr[$type_search];
    $item_arr = $database->executeSql($sql);
    if (count($item_arr) == 0) {
        echo "<div style='color:red'>NO MENU</div>";
    } else {
        foreach ($item_arr as $value) {
            $img = ($value->menu_img != "" ? $value->menu_img : "no_img");

            if ($value->menu_status == "1") {
                ?>
                <div class="col-sm-3">
                    <div class="btn_menu_item_disable"><img src="img_product/<?= $img ?>"><br><?= $value->menu_name ?><br><span><?= number_format($value->menu_price) ?></span></div>    
                </div>
                <?
            } else if ($value->menu_status == "2") {
                ?>
                <div class="col-sm-3">
                    <div class="btn_menu_item" data-id="<?= $value->menu_id ?>"><img src="img_product/<?= $img ?>"><br><?= $value->menu_name ?><br><span class="pricecolor"><?= number_format($value->menu_price) ?></span></div>    
                </div>
                <?
            }
        }
    }
}else{
       echo "<div style='color:red'>NO MENU</div>";
}
?>