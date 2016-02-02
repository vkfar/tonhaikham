<?
//search
if (isset($_GET['search_type'])) {
    $txt_search = mysql_real_escape_string(trim($_REQUEST['search_txt']));
    $type_search = mysql_real_escape_string(trim($_REQUEST['search_type']));
    $type_search_arr['ID'] = "WHERE `menu`.menu_id LIKE '%$txt_search%' ";
    $type_search_arr['Menu'] = "WHERE `menu`.menu_name LIKE '%$txt_search%' ";
    $type_search_arr['Menu Category'] = "WHERE `menu_category`.menu_cate_name LIKE '%$txt_search%' ";
    $type_search_arr['Price'] = "WHERE `menu`.menu_price LIKE '%$txt_search%' ";
    $type_search_arr['Status'] = "WHERE `menu`.menu_status LIKE '%$txt_search%' ";
    
    $sql_menu = "SELECT `menu`.*, `menu_category`.menu_cate_name FROM `menu`  
        INNER JOIN `menu_category` ON `menu_category`.`menu_cate_id` = `menu`.`menu_cate_id`
        " . $type_search_arr[$type_search] . " ORDER BY `menu_category`.`menu_cate_name` ASC ";

} else { // no search 
    $sql_menu = "SELECT `menu`.*, `menu_category`.menu_cate_name FROM `menu`  
        INNER JOIN `menu_category` ON `menu_category`.`menu_cate_id` = `menu`.`menu_cate_id`
        ORDER BY `menu_category`.`menu_cate_name` ASC ";
}

$menu_detail_arr = $database->executeSql($sql_menu);
?>
<div style="padding: 20px;">
    <h4>Menu</h4>
    <ol class="breadcrumb" style="margin-bottom: 5px;">
         <li><a href="backoffice.php">Tonhaikham</a></li>
        <li><a href="main_manage.php">Manage Main</a></li>
        <li><a href="main_manage.php?page=menu">Menu</a></li>
        <?
        if (isset($_GET['search_type'])) {
            if ($type_search == "Status") {
                ?>
                <li><a href="main_manage.php?page=menu&search_txt=<?= $txt_search ?>&search_type=<?= $type_search ?>" class="active">Search : "<?= status_num_to_string($txt_search) ?>" By "<?= $type_search ?>" </a></li>
                <?
            } else {
                ?>
                <li><a href="main_manage.php?page=menu&search_txt=<?= $txt_search ?>&search_type=<?= $type_search ?>" class="active">Search : "<?= $txt_search ?>" By "<?= $type_search ?>" </a></li>
                <?
            }
           
        }
        ?>
    </ol>
    <div class="row">
        <div style="padding: 15px;">
                <form action="main_manage.php" method="GET" id="frm_search">
                <input type="hidden" name="page" value="menu">
                <input type="text" placeholder="Enter Search Info..." id="search_txt" name="search_txt" style="border: 1px solid #cccccc;padding: 3px;"> 
                <select name="search_type" style="border: 1px solid #cccccc;padding: 3px;" id="search_type">
                    <option value="ID">ID</option>
                    <option value="Menu">Menu</option>
                    <option value="Menu Category">Menu Category</option>
                    <option value="Price">Price</option>
                    <option value="Status">Status</option>
                </select>
                <input type="submit" value="Search">
            </form>
        </div>
    </div>

    <div class="table-responsive box-bf-content" style="overflow: auto">
        <table class="table table-bordered"> 
            <tr style="background-color: #990000;color: white">
                <th>ID</th>
                <th>Menu</th>
                <th>Menu Category</th>
                <th>Price</th>
                <th>Picture</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?
            foreach ($menu_detail_arr as $menu_detail_value) {
                ?>
                <tr data-id='<?= $menu_detail_value->menu_id ?>'>
                    <td><?= $menu_detail_value->menu_id ?></td>
                    <td><?= $menu_detail_value->menu_name ?></td>
                    <td><?= $menu_detail_value->menu_cate_name ?></td>
                    <td style="text-align: right"><?= number_format($menu_detail_value->menu_price) ?></td>
                    <?
                    $menu_img = "img_product/" . $menu_detail_value->menu_img;
                    if ($menu_detail_value->menu_img == "") {
                        $menu_img = "img_product/no_img.bmp";
                    } elseif (!file_exists($menu_img)) {
                        $menu_img = "img_product/no_img.bmp";
                    }
                    ?>
                    <td style="text-align: center"><img src="<?= $menu_img ?>" style="width: 80px;height: 80px;"></td>           
                    <?
                    if ($menu_detail_value->menu_status == 2) {
                        echo "<td class='success'>Enable";
                    } else {
                        echo "<td class='danger'>Disable";
                    }
                    ?>
                    </td>
                    <td style="text-align: center"><span class="glyphicon glyphicon-edit btn-menu-ed" data-toggle="modal" data-target="#this_modal"></span>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-trash btn-menu-del"></span></td>
                </tr>
                <?
            }
            ?>
        </table>
    </div>
    <div style="text-align: right">
        <button class="btn btn-primary" id="btn-pop-addmenu" data-toggle="modal" data-target="#this_modal">Add Menu</button>
    </div>  
</div>
