<?
require_once('includes/config.inc.php');

login_checker(array(1, 2, 4));

$sys_user = $_SESSION["sess_user"];
$sys_user_id = $_SESSION["sess_user_id"];
$sys_user_role = $_SESSION["sess_user_role"];

$database = new Database();
$database->openConnection();
$sql = "SELECT `order_detail`.*,`table_detail`.`table_name`, `menu`.menu_name,  `user`.user_name FROM `order_detail` 
    INNER JOIN `order` ON `order_detail`.`order_id` = `order`.`order_id` 
    INNER JOIN `table_detail` ON `table_detail`.`table_id` = `order`.`table_id` 
    INNER JOIN `menu` ON `menu`.menu_id = `order_detail`.menu_id
       INNER JOIN `user` ON `user`.user_id = `order_detail`.user_id
    WHERE `order_detail_status` = '3' OR `order_detail_status` = '4' 
    ORDER BY order_detail_id ASC ";
$order_detail_arr = $database->executeSql($sql);
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

        <title>Tonhaikham</title>

        <!-- Bootstrap core CSS -->
        <link href="dist/css/bootstrap.css" rel="stylesheet">

        <link href="css/default.css" rel="stylesheet">
    </head>
    <!-- NAVBAR
    ================================================== -->
    <body style="background-color: #E7E4E4">

        <div class="navbar-wrapper">
            <div class="navbar navbar-inverse navbar-static-top">

                <div class="container">
                    <ul class="nav navbar-nav">

                        <li><a href="backoffice.php" style="color: yellow"><b><span class="glyphicon glyphicon-tree-conifer"></span> Tonhaikham</b></a></li>
                         <?
                        if (in_array($sys_user_role, array(1, 2, 4))) { // waiter,cashier,owner
                            echo ' <li class="active"><a href="serve.php" style="color: #990000"> <b>Serve</b></a></li>';
                        }
                        if (in_array($sys_user_role, array(1, 2, 3))) {  // cook,cashier,owner
                            echo '<li><a href="kitchen.php"> <b>Kitchen</b></a></li>';
                        }
                        if (in_array($sys_user_role, array(1, 2, 4))) {  // waiter,cashier,owner
                            echo ' <li><a href="order.php"> <b>Order</b></a></li>';
                        }
                        ?>
           
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a style="color: #00cc00"><span class="glyphicon glyphicon-user"></span> <?= $sys_user . "(" . user_role($sys_user_role) . ")" ?></a>
                        </li>
                        <li>
                            <a class="btn_logout">Logout <span class="glyphicon glyphicon-log-out"></span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container">

            <div id="box_monitor" style="background-color: white">
                 <ol class="breadcrumb" style="margin-bottom: 5px;">
                    <li><a href="Backoffice.php">Tonhaikham</a></li>
                    <li><a href="service.php">Service</a></li>
                    <li><a href="serve.php">Serve</a></li>
                </ol>
                <table class="table" id="monitor_table">
                    <tr style="background-color: #990000;color: white">

                        <th>Menu</th>
                        <th>Quantity</th>
                        <th>Table</th>
                        <th>Status</th>
                        <th>&nbsp;</th>
                        <th>User</th>
                        <th>Datetime</th>
                    </tr>
                    <?
                    foreach ($order_detail_arr as $order_detail_value) {
                        $tr_color = "";
                        if ($order_detail_value->order_detail_status == '3') {
//                            $tr_color = "class='success' ";
                        } else if ($order_detail_value->order_detail_status == '4') {
                            $tr_color = "class='danger' ";
                        }
                        ?>
                        <tr <?= $tr_color ?> data-id="<?= $order_detail_value->order_detail_id ?>">
                            <td><?= $order_detail_value->menu_name ?></td>
                            <td><?= $order_detail_value->order_quantity ?></td>
                            <td><?= $order_detail_value->table_name ?></td>
                            <td>
                                <?
                                if ($order_detail_value->order_detail_status == '3') {
                                    echo "Finish";
                                } else if ($order_detail_value->order_detail_status == '4') {
                                    echo "Can't Cook";
                                }
                                ?>
                            </td>
                            <td>
                                <?
                                if ($order_detail_value->order_detail_status == '3') {
                                    echo '<button type="button" class="btn btn-primary btn-serve" data-id="cook_finish_serve">Serve</button>';
                                } else if ($order_detail_value->order_detail_status == '4') {
                                    echo '<button type="button" class="btn btn-danger btn-serve" data-id="can_not_cook_serve">Tell Customer</button>';
                                }
                                ?>

                            </td>
                            <td><?= $order_detail_value->user_name ?></td>
                            <td><?= $order_detail_value->order_detail_date ?></td>
                        </tr>
                        <?
                    }
                    ?>
                </table>
            </div>

            <hr class="featurette-divider">

            <!-- /END THE FEATURETTES -->


            <!-- FOOTER -->
            <footer>
                <p class="pull-right"><a href="#">Back to top</a></p>

            </footer>

        </div><!-- /.container -->

        <!-- Modal -->
        <div class="modal fade" id="this_modal">
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
        <script src="js/jquery.js"></script>
        <script>
            window.setInterval(function() {
                $.post("ajax/ajax_load_more_serve.php", {}, function(data) {
                    $("#monitor_table").html(data);
                });

            }, 5000);
            $(function() {
                $("#box_monitor").on("click", ".btn-serve", function() {
                    var this_item = $(this);
                    var food_id = this_item.parent().parent().attr("data-id");
                    var btn_type = $(this).attr("data-id");
                    $.post("ajax/ajax_order_status_process.php", {btn: btn_type, id: food_id}, function(data) {

                        if (data.result == "ok") {

                            this_item.parent().parent().hide();

                        } else {
                            alert("Error");
                        }

                    }, 'json');


                });
            });
        </script>
        <script src="js/ajax_log_out.js"></script>
        <script src="plugin/datetime/src/DateTimePicker.js"></script>
        <script src="dist/js/bootstrap.js"></script>
    </body>
</html>
