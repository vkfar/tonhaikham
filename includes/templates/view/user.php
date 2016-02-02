<?
$txt_search = mysql_real_escape_string(trim($_REQUEST['search_txt']));
$type_search = mysql_real_escape_string(trim($_REQUEST['search_type']));

$type_search_arr['ID'] = "WHERE `user`.user_id LIKE '%$txt_search%' ";
$type_search_arr['Username'] = "WHERE `user`.user LIKE '%$txt_search%' ";
$type_search_arr['Name'] = "WHERE `user`.user_name LIKE '%$txt_search%' ";
$type_search_arr['Surname'] = "WHERE `user`.user_surname LIKE '%$txt_search%' ";
$type_search_arr['User Role'] = "WHERE `user`.user_role LIKE '%$txt_search%' ";
$type_search_arr['Status'] = "WHERE `user`.user_status LIKE '%$txt_search%' ";

$sql_user = "SELECT * FROM user " . $type_search_arr[$type_search] . " ORDER BY user_id DESC ";
$user_detail_arr = $database->executeSql($sql_user);
?>
<div style="padding: 20px;">
    <h4>User</h4>
    <ol class="breadcrumb" style="margin-bottom: 5px;">
         <li><a href="backoffice.php">Tonhaikham</a></li>
        <li><a href="main_manage.php">Main Manage</a></li>
        <li><a href="main_manage.php?page=user">User</a></li>
        <?
        if (isset($_GET['search_type'])) {
            
            if ($type_search == "Status") {
                ?>
                <li><a href="main_manage.php?page=user&search_txt=<?= $txt_search ?>&search_type=<?= $type_search ?>" class="active">Search : "<?= status_num_to_string($txt_search) ?>" By "<?= $type_search ?>" </a></li>
                <?
            } else {
                ?>
                <li><a href="main_manage.php?page=user&search_txt=<?= $txt_search ?>&search_type=<?= $type_search ?>" class="active">Search : "<?= $txt_search ?>" By "<?= $type_search ?>" </a></li>
                <?
            }
            
        }
        ?>
    </ol>
    <div class="row">
        <div style="padding: 15px;">
            <form action="main_manage.php" method="GET" id="frm_search">
                <input type="hidden" name="page" value="user">
                <input type="text" placeholder="Enter Search Info..." id="search_txt" name="search_txt" style="border: 1px solid #cccccc;padding: 3px;"> 
                <select name="search_type" style="border: 1px solid #cccccc;padding: 3px;" id="search_type">
                    <option value="ID">ID</option>
                    <option value="Username">Username</option>
                    <option value="Name">Name</option>
                    <option value="Surname">Surname</option>
                    <option value="User Role">User Role</option>
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
                <th>Username</th>
                <th>Password</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Address</th>
                <th>Tel</th>
                <th>User Role</th>
                <th>More Information</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?
            foreach ($user_detail_arr as $user_detail_value) {
                ?>
                <tr data-id='<?= $user_detail_value->user_id ?>'>
                    <td><?= $user_detail_value->user_id ?></td>
                    <td><?= $user_detail_value->user ?></td>
                    <td><?= $user_detail_value->user_password ?></td>
                    <td><?= $user_detail_value->user_name ?></td>
                    <td><?= $user_detail_value->user_surname ?></td>
                    <td><?= $user_detail_value->user_add ?></td>
                    <td><?= $user_detail_value->user_tel ?></td>
                    <td><?= user_role($user_detail_value->user_role) ?></td>
                    <td ><?= $user_detail_value->user_more_info ?></td>
                    <?
                    if ($user_detail_value->user_status == 2) {
                        echo "<td class='success'>Enable";
                    } else {
                        echo "<td class='danger'>Disable";
                    }
                    ?>
                    </td>
                    <td><span class="glyphicon glyphicon-edit btn-user-ed" data-toggle="modal" data-target="#this_modal"></span>&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-trash btn-user-del"></span></td>
                </tr>
                <?
            }
            ?>
        </table>
    </div>
    <div style="text-align: right">
        <button class="btn btn-primary" id="btn-pop-adduser" data-toggle="modal" data-target="#this_modal">Add User</button>
    </div>
</div>
