<?
$txt_search = mysql_real_escape_string(trim($_REQUEST['search_txt']));
$type_search = mysql_real_escape_string(trim($_REQUEST['search_type']));

// array search
$type_search_arr['ID'] = "WHERE `menu_category`.menu_cate_id LIKE '%$txt_search%' ";
$type_search_arr['Menu Category'] = "WHERE `menu_category`.menu_cate_name LIKE '%$txt_search%' ";
$type_search_arr['Menu Quantity'] = "WHERE `menu_category`.count_menu LIKE '%$txt_search%' ";
//
$sql_menu = "SELECT * FROM (SELECT `menu_category`.*, count(menu_id) as count_menu FROM `menu_category` 
    LEFT JOIN `menu` ON `menu_category`.menu_cate_id = `menu`.menu_cate_id 
    GROUP BY `menu_category`.menu_cate_id  ORDER BY `menu_cate_id` ASC) AS menu_category  " . $type_search_arr[$type_search] . "   ";
$menu_detail_arr = $database->executeSql($sql_menu);
?>
<div style="padding: 20px;">
    <h4>Menu Category</h4>
    <ol class="breadcrumb">
         <li><a href="backoffice.php">Tonhaikham</a></li>
        <li><a href="main_manage.php">Manage Main</a></li>
        <li><a href="main_manage.php?page=menu_type">Menu Category</a></li>
        <?
        if (isset($_GET['search_type'])) {
            ?>
        <li><a href="main_manage.php?page=menu&search_txt=<?=$txt_search?>&search_type=<?=$type_search?>" class="active">Search : "<?=$txt_search?>" By "<?=$type_search?>" </a></li>
            <?
        }
        ?>
    </ol>

    <div class="row">
        <div style="padding: 15px;">
            <form action="main_manage.php" method="GET">
                <input type="hidden" name="page" value="menu_type">
                <input type="text" placeholder="Enter Search Info..." name="search_txt" style="border: 1px solid #cccccc;padding: 3px;"> 
                <select name="search_type" style="border: 1px solid #cccccc;padding: 3px;">
                    <option value="ID">ID</option>
                    <option value="Menu Category">Menu Category</option>
                    <option value="Menu Quantity">Menu Quantity</option>
                </select>
                <input type="submit" value="Search">
            </form>
        </div>
    </div>

    <div class="table-responsive" style="overflow: auto">
        <table class="table table-bordered"> 
            <tr style="background-color: #990000;color: white">
                <th>ID</th>
                <th>Menu Category</th>
                <th>Menu Quantity</th>
                <th>Actions</th>
            </tr>
            <?
            foreach ($menu_detail_arr as $menu_detail_value) {
                $sql_count_item = "SELECT *  FROM menu WHERE menu_cate_id = '" . $menu_detail_value->menu_cate_id . "' ";
                ?>
                <tr data-id='<?= $menu_detail_value->menu_cate_id ?>'>
                    <td><?= $menu_detail_value->menu_cate_id ?></td>
                    <td class="c_menu_type"><a href="main_manage.php?page=menu&search_txt=<?= $menu_detail_value->menu_cate_name ?>&search_type=Menu+Category"><?= $menu_detail_value->menu_cate_name ?></a></td>
                    <td><?= $menu_detail_value->count_menu ?></td>
                    <td style="text-align: center"><span class="glyphicon glyphicon-edit btn-menutype-ed" data-toggle="modal" data-target="#this_modal"></span>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-trash btn-menutype-del"></span></td>
                </tr>
                <?
            }
            ?>
        </table>
    </div>
    <div style="text-align: right">
        <button class="btn btn-primary" id="btn-pop-addmenutype" data-toggle="modal" data-target="#this_modal">Add Menu Category</button>
    </div>  
</div>
