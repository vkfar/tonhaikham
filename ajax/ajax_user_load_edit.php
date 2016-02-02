<?php
include '../includes/config.inc.php';
// connect database 
$database = new Database();
$database->openConnection();
$u_id = mysql_real_escape_string($_REQUEST['u_id']);
$sql = "SELECT * FROM user WHERE user_id = '$u_id' ";
$user_detail_arr = $database->executeSql($sql);
?>
<form role="form">
    <div class="form-group">
        <label>ID</label>
        <input type="text" class="form-control" id="txt-user-id" value="<?= $user_detail_arr[0]->user_id ?>" disabled="true">        
        <label>Username:</label>
        <input type="text" class="form-control" id="txt-user" value="<?= $user_detail_arr[0]->user ?>">
        <label>Password:</label>
        <input type="password" class="form-control" id="txt-pass" value="<?= $user_detail_arr[0]->user_password ?>">
        <label>Name:</label>
        <input type="text" class="form-control" id="txt-name" value="<?= $user_detail_arr[0]->user_name ?>">
        <label>Surname:</label>
        <input type="text" class="form-control" id="txt-surname" value="<?= $user_detail_arr[0]->user_surname ?>">
        <label>Address:</label>
        <input type="text" class="form-control" id="txt-address" value="<?= $user_detail_arr[0]->user_add ?>">
        <label>Tell:</label>
        <input type="text" class="form-control" id="txt-tell" value="<?= $user_detail_arr[0]->user_tel ?>">
        <label>User Role:</label>
        <select class="form-control" id="txt-role">
            <?
            $role[1] = "Owner";
            $role[2] = "Cashier";
            $role[3] = "Cook";
            $role[4] = "Waiter";
            ?>        
            <option value="<?= $user_detail_arr[0]->user_role ?>"><?= $role[$user_detail_arr[0]->user_role] ?></option>
            <?
            for ($index = 1; $index < 5; $index++) {
                if ($user_detail_arr[0]->user_role != $index) {
                    echo '<option value="' . $index . '">' . $role[$index] . '</option>';
                }
            }
            ?>
        </select>
        <label>More Information:</label>
        <textarea class="form-control" id="txt-info"><?= $user_detail_arr[0]->user_more_info ?></textarea>
        <label>User Status:</label>
        <select class="form-control" id="txt-userstatus">
            <?
            if ($user_detail_arr[0]->user_status == 2) {
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