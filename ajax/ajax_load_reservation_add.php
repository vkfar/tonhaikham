<?php
include '../includes/config.inc.php';
// connect database 
?>
<form role="form">
    <div class="form-group">
        <label>Name:</label>
        <input type="text" class="form-control" id="txt_b_name" placeholder="Enter Name">
    </div>
    <div class="form-group">
        <label>Tel:</label>
        <input type="text" class="form-control date" id="txt_b_tell" placeholder="Enter Tell">
    </div>
    <?
    $date = new DateTime();
    ?>
    <div class="form-group">
        <label for="exampleInputFile">Reservation on:</label>
        <div class='input-group date' id='datetimepicker4'>
            <input type='text' class="form-control" id="txt_b_date" data-field="datetime" data-min="<?= $date->format('d-m-Y H:i'); ?>" readonly style="cursor: pointer"/>
            <div id="dtBox"></div>
            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
            </span>
        </div>
    </div>
    <div class="form-group">
        <label for="exampleInputFile">Note</label>
        <textarea class="form-control" id="txt_b_note" rows="3" placeholder="Enter Note something..."></textarea>
    </div>
</form>
<script>
    $(function() {
        $("#dtBox").DateTimePicker();
    });
</script>

