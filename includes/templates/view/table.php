<?
$txt_search = mysql_real_escape_string(trim($_REQUEST['search_txt']));
$type_search = mysql_real_escape_string(trim($_REQUEST['search_type']));

$type_search_arr['ID'] = "WHERE `table_detail`.table_id LIKE '%$txt_search%' ";
$type_search_arr['Table Name'] = "WHERE `table_detail`.table_name LIKE '%$txt_search%' ";

$sql_tb = "SELECT `table_detail`.*,`table_status`.tb_status FROM `table_detail` 
    INNER JOIN `table_status` ON `table_detail`.tb_status_id = `table_status`.`tb_status_id` 
     " . $type_search_arr[$type_search] . "
    ORDER BY `table_name` ASC ";

$tb_detail_arr = $database->executeSql($sql_tb);
?>
<div style="padding: 20px;">
    <h4>Table</h4>
    <ol class="breadcrumb">
         <li><a href="backoffice.php">Tonhaikham</a></li>
        <li><a href="main_manage.php">Main Manage</a></li>
        <li><a href="main_manage.php?page=table">Table</a></li>
         <?
        if (isset($_GET['search_type'])) {
            ?>
        <li><a href="main_manage.php?page=table&search_txt=<?=$txt_search?>&search_type=<?=$type_search?>" class="active">Search : "<?=$txt_search?>" By "<?=$type_search?>" </a></li>
            <?
        }
        ?>
    </ol>
    
     <div class="row">
        <div style="padding: 15px;">
            <form action="main_manage.php" method="GET">
                <input type="hidden" name="page" value="table">
                <input type="text" placeholder="Enter Search Info..." name="search_txt" style="border: 1px solid #cccccc;padding: 3px;"> 
                <select name="search_type" style="border: 1px solid #cccccc;padding: 3px;">
                    <option value="ID">ID</option>
                    <option value="Table Name">Table Name</option>
      
                </select>
                <input type="submit" value="Search">
            </form>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-bordered"> 
            <tr style="background-color: #990000;color: white">
                <th>ID</th>
                <th>Table Name</th>
                <th>Actions</th>
            </tr>
            <?
            foreach ($tb_detail_arr as $tb_detail_value) {
                $tr_color = "";
                $td_actions = "";
                if ($tb_detail_value->tb_status_id == "2") {
                    $tr_color = 'class="danger"';
                    $td_actions = "Unaviable";
                } else if ($tb_detail_value->tb_status_id == "3") {
                    $tr_color = 'class="warning"';
                    $td_actions = "Unaviable!";
                } else {
                    $td_actions = '<span class="glyphicon glyphicon-edit btn-tb-ed" data-toggle="modal" data-target="#this_modal"></span>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-trash btn-tb-del"></span>';
                }
                ?>
                <tr <?= $tr_color ?> data-id='<?= $tb_detail_value->table_id ?>'>
                    <td><?= $tb_detail_value->table_id ?></td>
                    <td><?= $tb_detail_value->table_name ?></td>
                  
                    <td><?= $td_actions ?></td>
                </tr>
                <?
            }
            ?>
        </table>
    </div>
    <div style="text-align: right">
        <button class="btn btn-primary" id="btn-pop-addtb" data-toggle="modal" data-target="#this_modal">Add Table</button>
    </div>
</div>
