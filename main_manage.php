<?
require_once('includes/config.inc.php');

login_checker(array(1, 2));


$sys_user = $_SESSION["sess_user"];
$sys_user_id = $_SESSION["sess_user_id"];
$sys_user_role = $_SESSION["sess_user_role"];

$database = new Database();
$database->openConnection();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="expires" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <link rel="shortcut icon" href="../../assets/ico/favicon.png">
        <link rel="stylesheet" type="text/css" href="plugin/datetime/src/DateTimePicker.css" />
        <title>Tonhaikham </title>
        <link href="dist/css/bootstrap.css" rel="stylesheet">
        <link href="css/default.css" rel="stylesheet">
        <style>
            .glyphicon-trash, .glyphicon-edit{
                cursor: pointer;
            }
        </style>
    </head>
    <body style="background-color: #E7E4E4;">

        <?
        include TEMPLATE_PATH . 'nav_bar_1.php';
        ?>

        <div class="container" style="background-color: white;">

            <div class="row" style="min-height: 400px;">
                <div class="col-lg-2" style="background-color: #3276B1;color: white;font-weight: bold;padding-left: 0px;padding-right: 0px;">
                    <div style="background-color: #222222;padding: 5px;color: white;border-top: 1px solid #E7E4E4;"> <span class="glyphicon glyphicon-info-sign"></span>  Manage Main </div>
                    <?
                    if ($sys_user_role == 1) {
                        ?>
                        <div style="border-bottom: 1px solid #E7E4E4;padding: 10px;"><a style="color: white" href="main_manage?page=menu_type">Menu Category</a></div>
                        <div style="border-bottom: 1px solid #E7E4E4;padding: 10px;"><a style="color: white" href="main_manage?page=menu">Menu </a></div>
                        <div style="border-bottom: 1px solid #E7E4E4;padding: 10px;"><a style="color: white" href="main_manage?page=user">User</a></div>
                        <div style="border-bottom: 1px solid #E7E4E4;padding: 10px;"><a style="color: white" href="main_manage?page=member">Member</a></div>
                        <div style="border-bottom: 1px solid #E7E4E4;padding: 10px;"><a style="color: white" href="main_manage?page=discount">Discount</a></div>
                        <div style="border-bottom: 1px solid #E7E4E4;padding: 10px;"><a style="color: white" href="main_manage?page=table">Table</a></div>
                        <div style="border-bottom: 1px solid #E7E4E4;padding: 10px;"><a style="color: white" href="main_manage?page=bill_setting">Bill Setting</a></div>
                        <?
                    } else if ($sys_user_role == 2) {
                        ?>
                        <div style="border-bottom: 1px solid #E7E4E4;padding: 10px;"><a style="color: white" href="main_manage?page=member">Member</a></div>
                        <?
                    }
                    ?>

                </div>
                <div class="col-lg-10" >

                    <?
                    if (isset($_REQUEST['page'])) {
                        if ($sys_user_role == "2" && $_REQUEST['page'] != "member") {
                            include './includes/templates/view/page_not_found.php';
                        } else {
                            if (file_exists('./includes/templates/view/' . $_REQUEST['page'] . '.php')) {
                                include './includes/templates/view/' . $_REQUEST['page'] . '.php';
                            } else {
                                include './includes/templates/view/page_not_found.php';
                            }
                        }
                    } else {
                        echo "<div style='text-align:center'><br><br><h3>Welcome to main manage</h3><br><img src='img_project/main.png'></div>";
                    }
                    ?>

                </div>
            </div>
            <hr class="featurette-divider">
            <!-- /END THE FEATURETTES -->
            <!-- FOOTER -->
            <footer>
                <p class="pull-right"><a href="#">Back to top</a></p>
            </footer>

        </div><!-- /.container -->

        <!-- Modal -->
        <div class="modal fade" id="this_modal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->

        <script src="js/jquery.js"></script>
        <script src="plugin/datetime/src/DateTimePicker.js"></script>
        <script>
            function isImage(filename) {
                var ext = getExtension(filename);
                switch (ext.toLowerCase()) {
                    case 'jpg':
                    case 'gif':
                    case 'bmp':
                    case 'png':
                        //etc
                        return true;
                }
                return false;
            }
            function getExtension(filename) {
                var parts = filename.split('.');
                return parts[parts.length - 1];
            }
            $(function() {

                $("#search_type").change(function() {
                    var this_sel_val = $(this).val();
                    if (this_sel_val == "Status") {
                        var this_html_new_sel = "<SELECT id='search_txt' name='search_txt' style='border: 1px solid #cccccc;padding: 3px;'>";
                        this_html_new_sel += "<option value='1'>Disable</option>";
                        this_html_new_sel += "<option value='2'>Enable</option>";
                        this_html_new_sel += "</SELECT>";
                        $("#search_txt").remove();
                        $("#frm_search").prepend(this_html_new_sel);
                    } else if (this_sel_val == "User Role") {
                        var this_html_new_sel = "<SELECT id='search_txt' name='search_txt' style='border: 1px solid #cccccc;padding: 3px;'>";
                        this_html_new_sel += "<option value='1'>Owner</option>";
                        this_html_new_sel += "<option value='2'>Cashier</option>";
                        this_html_new_sel += "<option value='3'>Cook</option>";
                        this_html_new_sel += "<option value='4'>Waiter</option>";
                        this_html_new_sel += "</SELECT>";
                        $("#search_txt").remove();
                        $("#frm_search").prepend(this_html_new_sel);

                    } else {
                        var this_html_new_sel = '<input type="text" placeholder="Enter Search Info..." id="search_txt" name="search_txt" style="border: 1px solid #cccccc;padding: 3px;"> ';
                        $("#search_txt").remove();
                        $("#frm_search").prepend(this_html_new_sel);
                    }
                });


                //user

                $(".btn-user-del").click(function() {
                    var u_id = $(this).parent().parent().attr("data-id");
                    if (confirm("Do you want to delete?")) {
                        $.post("ajax/ajax_user_del.php", {u_id: u_id}, function(data) {
                            if (data.result == "yes") {
                                location.reload();
                            } else {
                                alert("error");
                            }
                        }, 'json');
                    }
                });

                $("#btn-pop-adduser").click(function() {

                    $("#myModalLabel").html("Add User");
                    var html = '<form role="form">';
                    html += '<div class="form-group">';
                    html += '<label>Username:</label>';
                    html += '<input type="text" class="form-control" id="txt-user">';
                    html += '<label>Password:</label>';
                    html += '<input type="password" class="form-control" id="txt-pass">';
                    html += '<label>Name:</label>';
                    html += '<input type="text" class="form-control" id="txt-name">';
                    html += '<label>Surname:</label>';
                    html += '<input type="text" class="form-control" id="txt-surname">';
                    html += '<label>Address:</label>';
                    html += '<input type="text" class="form-control" id="txt-address">';
                    html += '<label>Tell:</label>';
                    html += '<input type="text" class="form-control" id="txt-tell">';
                    html += '<label>User Role:</label>';
                    html += '<select class="form-control" id="txt-role">';
                    html += '<option value="1">Owner</option>';
                    html += '<option value="2">Cashier</option>';
                    html += '<option value="3">Cook</option>';
                    html += '<option value="4">Waiter</option>';
                    html += '</select>';
                    html += '<label>More Information:</label>';
                    html += '<textarea class="form-control" id="txt-info"></textarea>';
                    html += '</div>';
                    html += '<label>User status</label>';
                    html += '<select class="form-control" id="txt-userstatus">';
                    html += '<option value="1">Disable</opiton>';
                    html += '<option value="2">Enable</opiton>';
                    html += '</select>';
                    html += '</form>';
                    $(".modal-body").html(html);
                    $(".modal-footer").html('<button type="button" class="btn btn-primary btn-add-user">Save</button>');
                });

                $(".modal-footer").on("click", ".btn-add-user", function() {
                    var user = $("#txt-user").val();
                    var pass = $("#txt-pass").val();
                    var name = $("#txt-name").val();
                    var surname = $("#txt-surname").val();
                    var address = $("#txt-address").val();
                    var tell = $("#txt-tell").val();
                    var role = $("#txt-role").val();
                    var info = $("#txt-info").val();
                    var user_status = $("#txt-userstatus").val();
                    $.post("ajax/ajax_user_adduser.php", {user: user, pass: pass, name: name, surname: surname, address: address, tell: tell, role: role, info: info, user_status: user_status}, function(data) {
                        if (data.result == "yes") {
                            if (data.msg == "no") {
                                location.reload();
                            } else {
                                alert(data.msg);
                            }
                        } else {
                            alert("error");
                        }
                    }, 'json');


                });

                $(".btn-user-ed").click(function() {
                    var u_id = $(this).parent().parent().attr("data-id");
                    $(".modal-body").html("Loading...");
                    $.post("ajax/ajax_user_load_edit.php", {u_id: u_id}, function(data) {
                        $("#myModalLabel").html("Edit User");
                        $(".modal-body").html(data);
                        $(".modal-footer").html('<button type="button" class="btn btn-primary btn-edit-user">Save</button>');
                    });
                });

                $(".modal-footer").on("click", ".btn-edit-user", function() {
                    var user_id = $("#txt-user-id").val();
                    var user = $("#txt-user").val();
                    var pass = $("#txt-pass").val();
                    var name = $("#txt-name").val();
                    var surname = $("#txt-surname").val();
                    var address = $("#txt-address").val();
                    var tell = $("#txt-tell").val();
                    var role = $("#txt-role").val();
                    var info = $("#txt-info").val();
                    var user_status = $("#txt-userstatus").val();
                    $.post("ajax/ajax_user_edit.php", {user_id: user_id, user: user, pass: pass, name: name, surname: surname, address: address, tell: tell, role: role, info: info, user_status: user_status}, function(data) {
                        if (data.result == "yes") {
                            if (data.msg == "no") {
                                location.reload();
                            } else {
                                alert(data.msg);
                            }
                        } else {
                            alert("error");
                        }
                    }, 'json');


                });


                //end user

                // menu Type


                $("#btn-pop-addmenutype").click(function() {

                    $("#myModalLabel").html("Add Menu Category");
                    var html = '<form role="form">';
                    html += '<div class="form-group">';
                    html += '<label>Menu Category:</label>';
                    html += '<input type="text" class="form-control" id="txt-menutype">';
                    html += '</div>';
                    html += '</form>';
                    $(".modal-body").html(html);
                    $(".modal-footer").html('<button type="button" class="btn btn-primary btn-add-menutype">Save</button>');
                });
                $(".modal-footer").on("click", ".btn-add-menutype", function() {
                    var menu_type = $("#txt-menutype").val();

                    $.post("ajax/ajax_menu_type_add.php", {menu_type: menu_type}, function(data) {
                        if (data.result == "yes") {
                            if (data.msg == "no") {
                                location.reload();
                            } else {
                                alert(data.msg);
                            }
                        } else {
                            alert("error");
                        }
                    }, 'json');

                });

                $(".btn-menutype-ed").click(function() {
                    $("#myModalLabel").html("Edit Menu Category");
                    var menu_id = $(this).parent().parent().attr('data-id');
                    var menu_type = $(this).parent().siblings(".c_menu_type").text();
                    var html = '<form role="form">';
                    html += '<div class="form-group">';
                    html += '<label>Menu Category:</label>';
                    html += '<input type="hidden" class="form-control" id="txt-menu-id" value=' + menu_id + '>';
                    html += '<input type="text" class="form-control" id="txt-menutype" value=' + menu_type + '>';
                    html += '</div>';
                    html += '</form>';
                    $(".modal-body").html(html);
                    $(".modal-footer").html('<button type="button" class="btn btn-primary btn-edit-menutype">Save</button>');
                });
                $(".modal-footer").on("click", ".btn-edit-menutype", function() {
                    var menu_type = $("#txt-menutype").val();
                    var menu_id = $("#txt-menu-id").val();
                    $.post("ajax/ajax_menu_type_edit.php", {menu_type: menu_type, menu_id: menu_id}, function(data) {
                        if (data.result == "yes") {
                            if (data.msg == "no") {
                                location.reload();
                            } else {
                                alert(data.msg);
                            }
                        } else {
                            alert("error");
                        }
                    }, 'json');
                });
                $(".btn-menutype-del").click(function() {
                    var menu_id = $(this).parent().parent().attr('data-id');
                    if (confirm("Do you want to delete?")) {

                        $.post("ajax/ajax_menu_type_del.php", {menu_id: menu_id}, function(data) {
                            if (data.result == "yes") {
                                location.reload();
                            } else {
                                alert("error");
                            }
                        }, 'json');
                    }
                });
                // end menu type

                //menu 
                $("#btn-pop-addmenu").click(function() {
                    $("#myModalLabel").html("Add Menu");
                    $(".modal-body").html("Loading...");
                    $.post("ajax/ajax_menu_load_add.php", {}, function(data) {
                        $(".modal-body").html(data);
                    });
                    $(".modal-footer").html('<button type="button" class="btn btn-primary btn-add-menu-item">Save</button>');
                });

                $(".modal-footer").on("click", ".btn-add-menu-item", function() {
                    var menu_item = $("#txt-menu-item").val();
                    var menu_item_cate = $("#txt-menu-item-cate").val();
                    var menu_item_price = $("#txt-menu-item-price").val();
                    var menu_item_status = $("#txt-menu-item-status").val();
                    var menu_item_img = document.getElementById('txt-menu-item-file').files[0];
                    if (!(Number(menu_item_price))) {
                        alert("Price is only number");
                    } else {
                        if (menu_item == "") {
                            alert("Please Enter Menu");
                        } else {


                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'ajax/ajax_menu_upload_img_add.php');
                            var formData = new FormData();
                            xhr.onload = function() {
                                if (xhr.status == 200) {
                                    if ($.trim(this.responseText) == "Not ext") {
                                        alert("Not Allow this file");
                                    } else if ($.trim(this.responseText) == "Menu is duplicate!") {
                                        alert("Menu is duplicate!");
                                    } else {
                                        location.reload();
                                    }
                                } else {
                                    alert("UPLOAD ERROR TRY AGAIN !" + xhr.status);
                                }
                            }
                            formData.append('myfile', menu_item_img);
                            formData.append('menu_item', menu_item);
                            formData.append('menu_item_cate', menu_item_cate);
                            formData.append('menu_item_price', menu_item_price);
                            formData.append('menu_item_status', menu_item_status);
                            xhr.send(formData);
                        }
                    }
                });

                $(".box-bf-content").on("click", ".btn-menu-ed", function() {
                    var menu_item_id = $(this).parent().parent().attr('data-id');
                    $("#myModalLabel").html("Edit Menu");
                    $(".modal-body").html("Loading...");
                    $.post("ajax/ajax_menu_load_edit.php", {menu_item_id: menu_item_id}, function(data) {
                        $(".modal-body").html(data);
                    });
                    $(".modal-footer").html('<button type="button" class="btn btn-primary btn-edit-menu-item">Save</button>');
                });

                $(".modal-footer").on("click", ".btn-edit-menu-item", function() {
                    var menu_item = $("#txt-menu-item").val();
                    var menu_item_id = $("#txt-menu-item").attr("data-id");
                    var menu_item_cate = $("#txt-menu-item-cate").val();
                    var menu_item_price = $("#txt-menu-item-price").val();
                    var menu_item_status = $("#txt-menu-item-status").val();
                    var menu_item_img = document.getElementById('txt-menu-item-file').files[0];
                    if (!(Number(menu_item_price))) {
                        alert("Price is only number");
                    } else {
                        if (menu_item == "") {
                            alert("Please Enter Menu");
                        } else {
//                    if (isImage(menu_item_img.name)) {
                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'ajax/ajax_menu_upload_img.php');
                            var formData = new FormData();
                            xhr.onload = function() {
                                if (xhr.status == 200) {
                                    if ($.trim(this.responseText) == "Not ext") {
                                        alert("Not Allow this file");
                                    } else if ($.trim(this.responseText) == "Menu is duplicate!") {
                                        alert("Menu is duplicate!");
                                    } else {
                                        location.reload();
                                    }
                                } else {
                                    alert("UPLOAD ERROR TRY AGAIN !" + xhr.status);
                                }
//                            location.reload();
                            }
                            formData.append('myfile', menu_item_img);
                            formData.append('menu_item', menu_item);
                            formData.append('menu_item_id', menu_item_id);
                            formData.append('menu_item_cate', menu_item_cate);
                            formData.append('menu_item_price', menu_item_price);
                            formData.append('menu_item_status', menu_item_status);
                            xhr.send(formData);
                        }
//                    } else {
//                        alert("This image file not support!");
//                    }
                    }
                });

                $(".box-bf-content").on("click", ".btn-menu-del", function() {
                    var menu_item_id = $(this).parent().parent().attr('data-id');
                    if (confirm("Do you want to delete?")) {
                        $.post("ajax/ajax_menu_del.php", {menu_item_id: menu_item_id}, function(data) {
                            if (data.result == "yes") {
                                location.reload();
                            } else {
                                alert("error");
                            }
                        }, 'json');
                    }
                });


                //end menu

                //bill setting ID btn-save-bill-setting
                $("#btn-save-bill-setting").click(function() {
                    var name = $("#txt-name-bill").val();
                    var add = $("#txt-add-bill").val();
                    var tell = $("#txt-tell-bill").val();
                    var foot = $("#txt-foot-bill").val();
                    $.post("ajax/ajax_bill_setting_save.php", {name: name, add: add, tell: tell, foot: foot}, function(data) {
                        if (data.result == "yes") {
                            alert("Save Complete!")
                        } else {
                            alert("error");
                        }
                    }, 'json');
                });
                //member ID btn-pop-addmem     

                $("#btn-pop-addmem").click(function() {
                    $("#myModalLabel").html("Add Member");
                    var html = '<form role="form">';
                    html += '<div class="form-group">';
                    html += '<label>Member Code</label>';
                    html += '<input type="text" class="form-control" id="txt-memcode">';
                    html += '<label>Start</label>';

                    html += '<div class="input-group date" id="datetimepicker4">';
                    html += '<input type="text" class="form-control" id="txt-memstart" data-field="date" readonly style="cursor: pointer"/>';
                    html += '<div id="dtBox"></div>';
                    html += '<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>';
                    html += '</span></div>';
                    html += '<label>Expire</label>';
                    html += '<div class="input-group date" id="datetimepicker4">';
                    html += '<input type="text" class="form-control" id="txt-memex" data-field="date" readonly style="cursor: pointer"/>';
                    html += '<div id="dtBox"></div>';
                    html += '<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>';
                    html += '</span></div>';
                    html += '<label>Name</label>';
                    html += '<input type="text" class="form-control" id="txt-memname">';
                    html += '<label>Surname</label>';
                    html += '<input type="text" class="form-control" id="txt-memsurname">';
                    html += '<label>Address</label>';
                    html += '<textarea class="form-control" id="txt-memadd"></textarea>';
                    html += '<label>Tel</label>';
                    html += '<input type="text" class="form-control" id="txt-memtell">';
                    html += '<label>Remark</label>';
                    html += '<textarea class="form-control" id="txt-memremark"></textarea>';
                    html += '<label>Discount</label>';
                    html += '<select class="form-control" id="txt-memdiscount">';
<?
$discount_java = $database->executeSql("SELECT * FROM `discount` ORDER BY discount_id");
foreach ($discount_java as $discount_java_val) {
    ?>
                        html += '<option value="<?= $discount_java_val->discount_id ?>"><?= $discount_java_val->discount . " (" . $discount_java_val->discount_rate . "%)" ?></opiton>';
    <?
}
?>
                    html += '</select>';
                    html += '<label>Status</label>';
                    html += '<select class="form-control" id="txt-memstatus">';
                    html += '<option value="1">Disable</opiton>';
                    html += '<option value="2">Enable</opiton>';
                    html += '</select>';
                    html += '</div>';
                    html += '</form>';

                    $(".modal-body").html(html);
                    $(".modal-footer").html('<button type="button" class="btn btn-primary btn-add-mem">Save</button>');
                    $("#dtBox").DateTimePicker();
                    $("#dtBox2").DateTimePicker();
                });

                $(".modal-footer").on("click", ".btn-add-mem", function() {
                    var memcode = $("#txt-memcode").val();
                    var memstart = $("#txt-memstart").val();
                    var memex = $("#txt-memex").val();
                    var memname = $("#txt-memname").val();
                    var memsurname = $("#txt-memsurname").val();
                    var memadd = $("#txt-memadd").val();
                    var memtell = $("#txt-memtell").val();
                    var memremark = $("#txt-memremark").val();
                    var memdiscount = $("#txt-memdiscount").val();
                    var memstatus = $("#txt-memstatus").val();
                    
                    $.post("ajax/ajax_member_add.php", {memcode: memcode, memstart: memstart, memex: memex, memname: memname, memsurname: memsurname, memadd: memadd, memtell: memtell, memremark: memremark, memdiscount: memdiscount, memstatus: memstatus}, function(data) {
                        if (data.result == "yes") {
                            if (data.msg == "no") {
                                location.reload();
                            } else {
                                alert(data.msg);
                            }

                        } else {
                            alert("error");
                        }
                    }, 'json');
                    
                });

                $(".btn-mem-ed").click(function() {
                    var memid = $(this).parent().parent().attr('data-id');
                    $(".modal-body").html("Loading...");
                    $.post("ajax/ajax_member_load_edit.php", {memid: memid}, function(data) {
                        $("#myModalLabel").html("Edit Member");
                        $(".modal-body").html(data);
                        $(".modal-footer").html('<button type="button" class="btn btn-primary btn-mem-edit-save">Save</button>');
                    });

                });

                $(".modal-footer").on("click", ".btn-mem-edit-save", function() {
                    var memid = $("#txt-memid").val();
                    var memcode = $("#txt-memcode").val();
                    var memstart = $("#txt-memstart").val();
                    var memex = $("#txt-memex").val();
                    var memname = $("#txt-memname").val();
                    var memsurname = $("#txt-memsurname").val();
                    var memadd = $("#txt-memadd").val();
                    var memtell = $("#txt-memtell").val();
                    var memremark = $("#txt-memremark").val();
                    var memdiscount = $("#txt-memdiscount").val();
                    var memstatus = $("#txt-memstatus").val();
                    $.post("ajax/ajax_member_edit.php", {memid: memid, memcode: memcode, memstart: memstart, memex: memex, memname: memname, memsurname: memsurname, memadd: memadd, memtell: memtell, memremark: memremark, memdiscount: memdiscount, memstatus: memstatus}, function(data) {
                        if (data.result == "yes") {
                            if (data.msg == "no") {
                                location.reload();
                            } else {
                                alert(data.msg);
                            }

                        } else {
                            alert("error");
                        }
                    }, 'json');
                });

                $(".btn-mem-del").click(function() {
                    var memid = $(this).parent().parent().attr('data-id');
                    if (confirm("Do you want to delete?")) {
                        $(".modal-body").html("Loading...");
                        $.post("ajax/ajax_member_delete.php", {memid: memid}, function(data) {
                            if (data.result == "yes") {
                                location.reload();
                            } else {
                                alert("error");
                            }
                        }, 'json');
                    }
                });

                // end setting ID btn-save-bill-setting

                // btn add btn-pop-addtb for add table
                $("#btn-pop-addtb").click(function() {
                    $("#myModalLabel").html("Add Table");
                    var html = '<form role="form">';
                    html += '<div class="form-group">';
                    html += '<label>Table Name</label>';
                    html += '<input type="text" class="form-control" id="txt-tablename">';
                    html += '</div>';
                    html += '</form>';
                    $(".modal-body").html(html);
                    $(".modal-footer").html('<button type="button" class="btn btn-primary btn-add-tb">Save</button>');
                });

                $(".modal-footer").on("click", ".btn-add-tb", function() {
                    var tb_name = $("#txt-tablename").val();
                    $.post("ajax/ajax_table_add.php", {tb_name: tb_name}, function(data) {
                        if (data.result == "yes") {
                            if (data.msg == "no") {
                                location.reload();
                            } else {
                                alert(data.msg);
                            }
                        } else {
                            alert("error");
                        }
                    }, 'json');
                });
                $(".btn-tb-ed").click(function() {
                    var tb_id = $(this).parent().parent().attr('data-id');
                    $(".modal-body").html("Loading...");
                    $.post("ajax/ajax_table_load_edit.php", {tb_id: tb_id}, function(data) {
                        $("#myModalLabel").html("Edit table");
                        $(".modal-body").html(data);
                        $(".modal-footer").html('<button type="button" class="btn btn-primary btn-tb-edit-save">Save</button>');
                    });
                });

                $(".modal-footer").on("click", ".btn-tb-edit-save", function() {
                    var tb_name = $("#txt-table-name").val();
                    var tb_id = $("#txt-table-name").attr("data-id");
                    $.post("ajax/ajax_table_edit.php", {tb_id: tb_id, tb_name: tb_name}, function(data) {
                        if (data.result == "yes") {
                            if (data.msg == "no") {
                                location.reload();
                            } else {
                                alert(data.msg);
                            }
                        } else {
                            alert("error");
                        }
                    }, 'json');
                });

                $(".btn-tb-del").click(function() {
                    var tb_id = $(this).parent().parent().attr('data-id');
                    $.post("ajax/ajax_table_del.php", {tb_id: tb_id}, function(data) {
                        if (data.result == "yes") {
                            location.reload();
                        } else {
                            alert("error");
                        }
                    }, 'json');
                });

                ////discount

                $("#btn-pop-discount").click(function() {
                    $("#myModalLabel").html("Add Discount");
                    var html = '<form role="form">';
                    html += '<div class="form-group">';
                    html += '<label>Discount</label>';
                    html += '<input type="text" class="form-control" id="txt-discount">';
                    html += '<label>Rate</label>';
                    html += '<input type="text" class="form-control" id="txt-rate">';
                    html += '</div>';
                    html += '</form>';
                    $(".modal-body").html(html);
                    $(".modal-footer").html('<button type="button" class="btn btn-primary btn-add-discount">Save</button>');
                });

                $(".modal-footer").on("click", ".btn-add-discount", function() {
                    var discount = $("#txt-discount").val();
                    var rate = $("#txt-rate").val();
                    $.post("ajax/ajax_discount_add.php", {discount: discount, rate: rate}, function(data) {
                        if (data.result == "yes") {
                            if (data.msg == "no") {
                                location.reload();
                            } else {
                                alert(data.msg);
                            }
                        } else {
                            alert("error");
                        }
                    }, 'json');
                });
                $(".btn-ds-ed").click(function() {
                    var discount_id = $(this).parent().parent().attr('data-id');
                    $(".modal-body").html("Loading...");
                    $.post("ajax/ajax_discount_load_edit.php", {discount_id: discount_id}, function(data) {
                        $("#myModalLabel").html("Edit Discount");
                        $(".modal-body").html(data);
                        $(".modal-footer").html('<button type="button" class="btn btn-primary btn-ds-edit-save">Save</button>');
                    });
                });

                $(".modal-footer").on("click", ".btn-ds-edit-save", function() {
                    var discount_id = $("#txt-dsdiscountid").val();
                    var discount = $("#txt-discount").val();
                    var rate = $("#txt-rate").val();
                    $.post("ajax/ajax_discount_edit.php", {discount_id: discount_id, discount: discount, rate: rate}, function(data) {
                        if (data.result == "yes") {
                            if (data.msg == "no") {
                                location.reload();
                            } else {
                                alert(data.msg);
                            }
                        } else {
                            alert("error");
                        }
                    }, 'json');
                });

                $(".btn-ds-del").click(function() {
                    var discount_id = $(this).parent().parent().attr('data-id');
                    $.post("ajax/ajax_discount_del.php", {discount_id: discount_id}, function(data) {
                        if (data.result == "yes") {
                            location.reload();
                        } else {
                            alert("error");
                        }
                    }, 'json');
                });



            });
        </script>
        <script src="js/ajax_log_out.js"></script>
        <script src="dist/js/bootstrap.js"></script>
    </body>
</html>
