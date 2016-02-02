<?
$txt_search = mysql_real_escape_string(trim($_REQUEST['search_txt']));
$type_search = mysql_real_escape_string(trim($_REQUEST['search_type']));

$type_search_arr['ID'] = "WHERE `member`.mem_id LIKE '%$txt_search%' ";
$type_search_arr['Member Code'] = "WHERE `member`.mem_code LIKE '%$txt_search%' ";
$type_search_arr['Issue Date'] = "WHERE `member`.mem_dateissue = '$txt_search' ";
$type_search_arr['Expire Date'] = "WHERE `member`.mem_expried = '$txt_search' ";
$type_search_arr['Name'] = "WHERE `member`.mem_name LIKE '%$txt_search%' ";
$type_search_arr['Surname'] = "WHERE `member`.mem_surname LIKE '%$txt_search%' ";
$type_search_arr['Address'] = "WHERE `member`.mem_add LIKE '%$txt_search%' ";
$type_search_arr['Tel'] = "WHERE `member`.mem_tel LIKE '%$txt_search%' ";
$type_search_arr['Remark'] = "WHERE `member`.mem_note LIKE '%$txt_search%' ";
$type_search_arr['Discount'] = "WHERE `member`.discount LIKE '%$txt_search%' ";
$type_search_arr['Status'] = "WHERE `member`.mem_status LIKE '%$txt_search%' ";

$sql_mem = "SELECT * FROM (SELECT `member`.*, `discount`.discount 
    FROM member INNER JOIN discount ON discount.discount_id = member.discount_id 
    ORDER BY `mem_id` DESC) AS member   " . $type_search_arr[$type_search] . " ";
$mem_detail_arr = $database->executeSql($sql_mem);
?>
<div style="padding: 20px;">
    <h4>Member</h4>
    <ol class="breadcrumb">
        <li><a href="backoffice.php">Tonhaikham</a></li>
        <li><a href="main_manage.php">Manage Main</a></li>
        <li><a href="main_manage.php?page=member">Member</a></li>
        <?
        if (isset($_GET['search_type'])) {
            ?>
            <li><a href="main_manage.php?page=member&search_txt=<?= $txt_search ?>&search_type=<?= $type_search ?>" class="active">
                    <?
                    if ($_GET['search_type'] == "Status") {
                        if($txt_search == 2){
                           $txt_search = "Enable";
                        }else{
                              $txt_search = "Disable";
                        }
                    }
                    ?>
                    Search : "<?= $txt_search ?>" By "<?= $type_search ?>" </a></li>
            <?
        }
        ?>
    </ol>

    <div class="row">
        <div style="padding: 15px;">
            <form action="main_manage.php" method="GET" id="frm_search">
                <input type="hidden" name="page" value="member">
                <input type="text" placeholder="Enter Search Info..." id="search_txt" name="search_txt" style="border: 1px solid #cccccc;padding: 3px;"> 
                <select name="search_type" style="border: 1px solid #cccccc;padding: 3px;" id="search_type">
                    <option value="ID">ID</option>
                    <option value="Member Code">Member Code</option>
                    <option value="Issue Date">Issue Date</option>
                    <option value="Expire Date">Expire Date</option>
                    <option value="Name">Name</option>
                    <option value="Surname">Surname</option>
                    <option value="Address">Address</option>
                    <option value="Tel">Tel</option>
                    <option value="Remark">Remark</option>
                    <option value="Discount">Discount</option>
                    <option value="Status">Status</option>
                </select>
                <input type="submit" value="Search">
            </form>
        </div>
    </div>

    <div class="table-responsive" style="overflow: auto">
        <table class="table table-bordered"> 
            <tr style="background-color: #990000;color: white">
                <th>ID</th>
                <th>Member Code</th>
                <th>Issue Date</th>
                <th>Expire Date</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Address</th>
                <th>Tel</th>
                <th>Remark</th>
                <th>Discount</th>
                <th>Status</th>               
                <th>Action</th>
            </tr>
            <?
            foreach ($mem_detail_arr as $mem_detail_value) {
                ?>
                <tr data-id='<?= $mem_detail_value->mem_id ?>'>
                    <td><?= $mem_detail_value->mem_id ?></td>
                    <td><?= $mem_detail_value->mem_code ?></td>
                    <td><?= mysql_date_to_string($mem_detail_value->mem_dateissue) ?></td>
                    <td><?= mysql_date_to_string($mem_detail_value->mem_expried) ?></td>
                    <td><?= $mem_detail_value->mem_name ?></td>
                    <td><?= $mem_detail_value->mem_surname ?></td>
                    <td><?= $mem_detail_value->mem_add ?></td>
                    <td><?= $mem_detail_value->mem_tel ?></td>
                    <td><?= $mem_detail_value->mem_note ?></td>
                    <td><?= $mem_detail_value->discount ?></td>
                    <?
                    if ($mem_detail_value->mem_status == 2) {
                        echo "<td class='success'>Enable";
                    } else {
                        echo "<td class='danger'>Disable";
                    }
                    ?>
                    </td>
                    <td><span class="glyphicon glyphicon-edit btn-mem-ed" data-toggle="modal" data-target="#this_modal"></span>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-trash btn-mem-del"></span></td>
                </tr>
                <?
            }
            ?>
        </table>
    </div>
    <div style="text-align: right">
        <button class="btn btn-primary" id="btn-pop-addmem" data-toggle="modal" data-target="#this_modal">Add Member</button>
    </div>
</div>
