<?
include '../includes/config.inc.php';

// connect database 
$database = new Database();
$database->openConnection();
$table_search = mysql_real_escape_string($_REQUEST['table_search']);
$table_class_btn = "btn-table";
$sql = "SELECT `table_detail`.*, `table_status`.tb_color  FROM `table_detail` INNER JOIN `table_status` ON `table_detail`.`tb_status_id` = `table_status`.`tb_status_id` WHERE `table_detail`.table_name LIKE '%$table_search%' ORDER BY table_name ASC";



$table = $database->executeSql($sql);
if(count($table) != 0){
    
foreach ($table as $value) {
    ?>
    <div class="col-sm-2" style="margin-bottom: 6px;margin-top: 5px">
        <a class="<?=$table_class_btn?> btn btn-default" data-id="<?=$value->table_id?>">
            <?
            $img = "img_project/table1.png";       
            ?>
            <img src="<?=$img?>" style="width: 100%">
            <br>
            <p style="color: <?= $value->tb_color ?>"><?= $value->table_name ?></p>
        </a>
    </div>  
    <?
}
}else{
    echo "No Table";
}
