<?php
include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$memid = mysql_real_escape_string($_REQUEST['memid']);
$sql = "SELECT `member`.*, `discount`.discount , `discount`.discount_rate FROM member INNER JOIN discount ON discount.discount_id = member.discount_id WHERE `member`.mem_id = '$memid' ORDER BY `mem_id` DESC ";
$mem_detail_arr = $database->executeSql($sql);
?>
<form role="form">
    <div class="form-group">
        <label>ID:</label>
        <input type="text" class="form-control" id="txt-memid" value="<?= $mem_detail_arr[0]->mem_id ?>" disabled="">
        <label>Member Code:</label>
        <input type="text" class="form-control" id="txt-memcode" value="<?= $mem_detail_arr[0]->mem_code ?>">
        <label>Start:</label>
        <div class="input-group date" id="datetimepicker4">
            <input type="text" class="form-control" data-min="<?= date("d-m-Y"); ?>" id="txt-memstart" value="<?= mysql_date_to_string($mem_detail_arr[0]->mem_dateissue) ?>" data-field="date" readonly style="cursor: pointer"/>
            <div id="dtBoxe"></div>
            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
            </span>
        </div>
        <label>Expire:</label>
        <div class="input-group date" id="datetimepicker4">
            <input type="text" class="form-control" id="txt-memex" data-min="<?= date("d-m-Y"); ?>" value="<?= mysql_date_to_string($mem_detail_arr[0]->mem_expried) ?>" data-field="date" readonly style="cursor: pointer"/>
            <div id="dtBoxe2"></div>
            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
            </span>
        </div>

        <label>Name:</label>
        <input type="text" class="form-control" id="txt-memname" value="<?= $mem_detail_arr[0]->mem_name ?>">
        <label>Surname:</label>
        <input type="text" class="form-control" id="txt-memsurname" value="<?= $mem_detail_arr[0]->mem_surname ?>">
        <label>Address:</label>
        <textarea class="form-control" id="txt-memadd"><?= $mem_detail_arr[0]->mem_add ?></textarea>
        <label>Tell:</label>
        <input type="text" class="form-control" id="txt-memtell" value="<?= $mem_detail_arr[0]->mem_tel ?>">
        <label>Remark:</label>
        <textarea class="form-control" id="txt-memremark"><?= $mem_detail_arr[0]->mem_note ?></textarea>
        <label>Discount</label>
        <select class="form-control" id="txt-memdiscount">
            <?
            $discount_java = $database->executeSql("SELECT * FROM `discount` ORDER BY discount_id");
            ?>
            <option value="<?= $mem_detail_arr[0]->discount_id ?>"><?= $mem_detail_arr[0]->discount . " (" . $mem_detail_arr[0]->discount_rate . "%)" ?></opiton>
                <?
                foreach ($discount_java as $discount_java_val) {
                    if ($mem_detail_arr[0]->discount_id != $discount_java_val->discount_id) {
                        ?>
                    <option value="<?= $discount_java_val->discount_id ?>"><?= $discount_java_val->discount . " (" . $discount_java_val->discount_rate . "%)" ?></opiton>
                        <?
                    }
                }
                ?>
        </select>
        <label>Status:</label>
        <select class="form-control" id="txt-memstatus">
            <?
            if ($mem_detail_arr[0]->mem_status == 2) {
                ?>
                <option value="2">Enable</opiton>
                <option value="1">Disable</opiton>
                    <?
                } else {
                    ?>
                <option value="1">Disable</opiton>
                <option value="2">Enable</opiton>
                    <?
                }
                ?>

        </select>

    </div>
</form>
<script>
    $(".dtpicker-close").click();
    $("#dtBoxe").DateTimePicker();
    $("#dtBoxe2").DateTimePicker();
</script>