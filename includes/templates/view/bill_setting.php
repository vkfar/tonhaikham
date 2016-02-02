<?
$bill_setting = $database->executeSql("SELECT * FROM `bill_setting` ");
?>

<div style="padding: 20px;">
    <h4>Bill Setting</h4>
    <ol class="breadcrumb">
         <li><a href="backoffice.php">Tonhaikham</a></li>
        <li><a href="main_manage.php">Manage Main</a></li>
        <li><a href="main_manage.php?page=bill_setting">Bill Setting</a></li>
    </ol>
    <div class="row">
        <div class="col-lg-6">
            <form role="form">
                <div class="form-group">
                    <label>Name</label>          
                    <input type="text" class="form-control" id="txt-name-bill" value="<?=$bill_setting[0]->name?>">
                    <label>Address</label>          
                    <input type="text" class="form-control" id="txt-add-bill" value="<?=$bill_setting[0]->address?>">
                    <label>Tel</label>          
                    <input type="text" class="form-control" id="txt-tell-bill" value="<?=$bill_setting[0]->tell?>">
                    <label>Footer</label>          
                    <input type="text" class="form-control" id="txt-foot-bill" value="<?=$bill_setting[0]->footer?>">
                </div>
            </form>
            <div style="text-align: right">
                <button class="btn btn-primary" id="btn-save-bill-setting">Save</button>
            </div>
        </div>
        <div class="col-lg-6"></div>
    </div>
</div>
