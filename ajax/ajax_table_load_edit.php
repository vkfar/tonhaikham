<?php
include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$table_id = mysql_real_escape_string($_REQUEST['tb_id']);
$sql = "SELECT * FROM table_detail WHERE table_id = '$table_id' ";
$table_detail_arr = $database->executeSql($sql);
?>
<form role="form">
    <div class="form-group">
        <label>Table name</label>
        <input type="text" class="form-control" id="txt-table-name" data-id="<?=$table_detail_arr[0]->table_id?>" value="<?=$table_detail_arr[0]->table_name?>">
    </div>
</form>