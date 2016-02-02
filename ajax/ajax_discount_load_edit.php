<?php
include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$discount_id = mysql_real_escape_string($_REQUEST['discount_id']);
$sql = "SELECT * FROM discount WHERE discount_id = '$discount_id' ";
$ds_detail_arr = $database->executeSql($sql);
?>
<form role="form">
    <div class="form-group">
        <label>ID</label>
        <input type="text" class="form-control" id="txt-dsdiscountid" value="<?= $ds_detail_arr[0]->discount_id ?>">
        <label>Discount</label>
        <input type="text" class="form-control" id="txt-discount" value="<?= $ds_detail_arr[0]->discount ?>">
        <label>Rate</label>
        <input type="text" class="form-control" id="txt-rate"  value="<?= $ds_detail_arr[0]->discount_rate ?>">
    </div>
</form>