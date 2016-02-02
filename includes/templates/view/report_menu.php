<?
$sql_menu = "SELECT `menu_category`.* FROM `menu_category` ORDER BY `menu_category`.`menu_cate_name` ASC ";
$menu_cate_arr = $database->executeSql($sql_menu);
?>
<div style="padding: 20px;">
    <h4>Report Menu</h4>
    <ol class="breadcrumb" style="margin-bottom: 5px;">
         <li><a href="backoffice.php">Tonhaikham</a></li>
        <li><a href="report.php">Report</a></li>
        <li><a href="report.php?page=menu">Report Menu</a></li>
        <?
        if (isset($_GET['search_type'])) {
            if ($type_search == "Status") {
                ?>
                <li><a href="report.php?page=menu&search_txt=<?= $txt_search ?>&search_type=<?= $type_search ?>" class="active">Search : "<?= status_num_to_string($txt_search) ?>" By "<?= $type_search ?>" </a></li>
                <?
            } else {
                ?>
                <li><a href="report.php?page=menu&search_txt=<?= $txt_search ?>&search_type=<?= $type_search ?>" class="active">Search : "<?= $txt_search ?>" By "<?= $type_search ?>" </a></li>
                <?
            }
        }
        ?>
    </ol>
    <br>
    <p><b>Menu Category</b></p>
    <div style="background-color: #E7E4E4;padding: 5px;margin-bottom: 10px;">       
        <?
        foreach ($menu_cate_arr as $menu_cate_val) {
            ?>
            <div class="col-sm-2">
                <input type="checkbox" class="ch_menu_cate" checked="" value="<?= $menu_cate_val->menu_cate_id ?>"> <b><?= $menu_cate_val->menu_cate_name ?></b>
            </div>
            <?
        }
        ?>
        <div class="clearfix"></div>
    </div>
    <p><b>Menu Status</b></p>
    <div style="background-color: #E7E4E4;padding: 5px;margin-bottom: 10px;">       
        <div class="col-sm-3">
            <select class="form-control" id="list_menu_status">
                <option value="">All</option>
                <option value="2">Enable</option>
                <option value="1">Disable</option>
            </select>
        </div>
        <div class="clearfix"></div>
    </div>
    <p><b>Show Menu picture</b></p>
    <div style="background-color: #E7E4E4;padding: 5px;margin-bottom: 10px;">       
        <div class="col-sm-3">
            <select class="form-control" id="show_img">
                <option value="">Disable</option>
                <option value="Enable">Enable</option> 
            </select>
        </div>
        <div class="clearfix"></div>
    </div>
    <p><b>Menu List</b></p>
    <div style="background-color: #E7E4E4;padding: 5px;margin-bottom: 10px;">    
        <div class="col-sm-3">
            <select class="form-control" id="list_menu_type">
                <option value="menu_id">Menu id</option>
                <option value="menu_name">Menu</option>
                <option value="menu_price">Price</option>
            </select>
        </div>
        <div class="col-sm-3">
            <select class="form-control" id="list_menu_order">
                <option value="DESC">Descending</option>
                <option value="ASC">Ascending</option>
            </select>
        </div>
        <div class="clearfix"></div>
    </div>

    <br>
    <div style="text-align: center"><input type="button" class="btn btn-sm btn-primary" value="Preview" id="btn-pdf-menu"></div>
    <br>
    <br>
    <iframe class="box-preview-report" width="100%" style="height: 800px;display: none" src=""></iframe>
</div>
