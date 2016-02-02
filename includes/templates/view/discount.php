<?
$txt_search = mysql_real_escape_string(trim($_REQUEST['search_txt']));
$type_search = mysql_real_escape_string(trim($_REQUEST['search_type']));

$type_search_arr['ID'] = "WHERE `discount`.discount_id LIKE '%$txt_search%' ";
$type_search_arr['Discount'] = "WHERE `discount`.discount LIKE '%$txt_search%' ";
$type_search_arr['Rate'] = "WHERE `discount`.discount_rate LIKE '%$txt_search%' ";

$sql_tb = "SELECT * FROM discount " . $type_search_arr[$type_search] . "  ORDER BY `discount_id` ASC ";
$ds_detail_arr = $database->executeSql($sql_tb);
?>
<div style="padding: 20px;">
    <h4>Discount</h4>
    <ol class="breadcrumb">
         <li><a href="backoffice.php">Tonhaikham</a></li>
        <li><a href="main_manage.php">Manage Main</a></li>
        <li><a href="main_manage.php?page=discount">Discount</a></li>
        <?
        if (isset($_GET['search_type'])) {
            ?>
            <li><a href="main_manage.php?page=discount&search_txt=<?= $txt_search ?>&search_type=<?= $type_search ?>" class="active">Search : "<?= $txt_search ?>" By "<?= $type_search ?>" </a></li>
            <?
        }
        ?>
    </ol>
    <div class="row">
        <div style="padding: 15px;">
            <form action="main_manage.php" method="GET" id="frm_search">
                <input type="hidden" name="page" value="discount">
                <input type="text" placeholder="Enter Search Info..." name="search_txt" style="border: 1px solid #cccccc;padding: 3px;"> 
                <select name="search_type" style="border: 1px solid #cccccc;padding: 3px;">
                    <option value="ID">ID</option>
                    <option value="Discount">Discount</option>
                    <option value="Rate">Rate</option>
                </select>
                <input type="submit" value="Search">
            </form>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered"> 
            <tr style="background-color: #990000;color: white">
                <th>ID</th>
                <th>Discount</th>
                <th>Rate</th>
                <th>Actions</th>
            </tr>
            <?
            foreach ($ds_detail_arr as $ds_detail_value) {
                ?>
                <tr data-id='<?= $ds_detail_value->discount_id ?>'>
                    <td><?= $ds_detail_value->discount_id ?></td>
                    <td><?= $ds_detail_value->discount ?></td>
                    <td><?= $ds_detail_value->discount_rate ?> %</td>
                    <td><span class="glyphicon glyphicon-edit btn-ds-ed" data-toggle="modal" data-target="#this_modal"></span>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-trash btn-ds-del"></span></td>
                </tr>
                <?
            }
            ?>
        </table>
    </div>
    <div style="text-align: right">
        <button class="btn btn-primary" id="btn-pop-discount" data-toggle="modal" data-target="#this_modal">Add Discount</button>
    </div>
</div>
