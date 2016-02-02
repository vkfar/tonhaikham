<?php
include '../includes/config.inc.php';
// connect database 
$database = new Database();
$reservation_id = mysql_real_escape_string($_REQUEST['reservation_id']);
$sql_reserve = "SELECT  * FROM reservation WHERE reserve_id = '$reservation_id'  ";
$reserve_arr = $database->executeSql($sql_reserve);
if ($reserve_arr > 0) {
    ?>
<form role="form">
    <div class="form-group">
        <label>Name:</label>
        <input type="text" class="form-control" id="txt_b_name" value="<?=$reserve_arr[0]->reserve_name?>">
    </div>
    <div class="form-group">
        <label>Tel:</label>
        <input type="text" class="form-control date" id="txt_b_tell" value="<?=$reserve_arr[0]->reserve_tel?>" placeholder="Enter Tell">
    </div>
    <?
    $date = new DateTime();
    ?>
    <div class="form-group">
        <label for="exampleInputFile">Reservation on:</label>
        <div class='input-group date' id='datetimepicker4'>
            <input type='text' class="form-control" id="txt_b_date" data-field="datetime" data-min="<?= $date->format('d-m-Y H:i'); ?>" value="<?=  mysql_string_date_time($reserve_arr[0]->reserve_on_date)?>" readonly style="cursor: pointer"/>
            <div id="dtBoxedit"></div>
            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
            </span>
        </div>
    </div>
    <div class="form-group">
        <label for="exampleInputFile">Note</label>
        <textarea class="form-control" id="txt_b_note" rows="3" placeholder="Enter Note something..."><?=$reserve_arr[0]->reserve_note?></textarea>
    </div>
</form>
    <?
} else {
    echo "Not Found!";
}
?>
<script>
  $(function() {
         $("#dtBoxedit").DateTimePicker();
      
  });
</script>

