<?
require_once('includes/config.inc.php');
login_checker(array(1, 2, 4));

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

        <title>Tonhaikham</title>

        <!-- Bootstrap core CSS -->
        <link href="dist/css/bootstrap.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="../../assets/js/html5shiv.js"></script>
          <script src="../../assets/js/respond.min.js"></script>
        <![endif]-->

        <!-- Custom styles for this template -->
        <link href="css/default.css" rel="stylesheet">
        <style>
            .btn_menu_item, .btn_load_new_table_again{
                cursor: pointer;
            }
            
        </style>
    </head>
    <!-- NAVBAR
    ================================================== -->
    <body style="background-color: #E7E4E4">

        <div class="navbar-wrapper">
            <!--<div class="container">-->

            <div class="navbar navbar-inverse navbar-static-top">
                <div class="container">

                    <ul class="nav navbar-nav navbar-right">

                        <li>
                            <a style="color: #00cc00"><span class="glyphicon glyphicon-user"></span> <?= $sys_user . "(" . user_role($sys_user_role) . ")" ?></a>
                        </li>
                        <li>
                            <a class="btn_logout">Logout <span class="glyphicon glyphicon-log-out"></span></a>
                        </li>
                    </ul>
                    <!--<div class="navbar-collapse collapse">-->
                    <ul class="nav navbar-nav">

                        <li><a href="backoffice.php" style="color: yellow"><b><span class="glyphicon glyphicon-tree-conifer"></span> Tonhaikham</b></a></li>
                        
                        <?
                        if (in_array($sys_user_role, array(1, 2, 4))) { // waiter,cashier,owner
                            echo ' <li><a href="serve.php" ><b>Serve</b></a></li>';
                        }
                        if (in_array($sys_user_role, array(1, 2, 3))) {  // cook,cashier,owner
                            echo '<li><a href="kitchen.php"> <b>Kitchen</b></a></li>';
                        }
                        if (in_array($sys_user_role, array(1, 2, 4))) {  // waiter,cashier,owner
                            echo ' <li class="active"><a href="order.php" style="color: #990000"><b>Order</b></a></li>';
                        }
                        ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Table<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a class="btn_load_table" data-id='0'>All table</a></li>
                                <?
                                $table_status = $database->executeSql("SELECT * FROM table_status");
                                foreach ($table_status as $table_status_value) {
                                    ?>
                                    <li><a class="btn_load_table" data-id='<?= $table_status_value->tb_status_id ?>'><?= $table_status_value->tb_status ?></a></li>
                                    <?
                                }
                                ?>
                            </ul>
                        </li>
                        <li id="btn_close_table_box"><a>X</a></li>



                    </ul>
                    <form class="navbar-form ">
                        <div class="form-group">
                            <input type="text" placeholder="Search Table" id="search_table" class="form-control">
                        </div>
                    </form>

                    <!--</div>-->




                </div>
            </div>

            <!--</div>-->
        </div>




        <!-- Marketing messaging and featurettes
        ================================================== -->
        <!-- Wrap the rest of the page in another container to center all the content. -->

        <div class="container">

            <div class="row" id="box_table_detail">

            </div>
            <div style="border: 2px solid #990000"></div>
            <div class="row" style="margin-top: 20px;background-color: white;padding-top: 10px;padding-bottom: 10px;border-radius: 5px;min-height: 400px;">
                <div class="col-lg-4" style="margin-bottom: 20px">

                    <div id="box_bill">
                        <div style="padding: 20px;background-color: #E7E4E4">
                            <h3>Please Choose Table</h3>

                            <p style="color: #990000">&nbsp;&nbsp;&nbsp;&nbsp;</p>

                        </div>
                    </div>
                </div>
                <div class="col-lg-8" >
                    <div class="row" id="box_pos_search" style="padding: 10px;background-color: #E7E4E4;margin-bottom: 5px;">
                        <input type="text" id="txt_menu_search"  placeholder="food info for search ..." style="border: 1px solid #cccccc;padding: 3px;">

                        <select style="border: 1px solid #cccccc;padding: 3px;" id="txt_menu_type_search">
                            <option value="ID">ID</option>
                            <option value="Menu">Menu</option>
                            <option value="Price">Price</option>
                            <option value="Status">Status</option>
                        </select>
                        <input type="button" value="search" id="btn_search_menu_pos">
                    </div>
                    <div class="row" id="box_menu" style="text-align: center">
                        <ul class="nav nav-tabs">
                            <?
                            $menu = $database->executeSql("SELECT * FROM menu_category");
                            foreach ($menu as $menu_value) {
                                ?>
                                <li style="border-radius: 0px"><a class="btn_menu" data-id="<?= $menu_value->menu_cate_id ?>"><?= $menu_value->menu_cate_name ?></a></li>
                                <?
                            }
                            ?>
                        </ul>
                        <br>

                    </div>
                    <!--this is food box detail-->
                    <div class="row" id="box_menu_item" style="text-align: center">

                    </div>
                </div>

            </div><!-- /.row -->


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





        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->

        <script src="js/jquery.js"></script>
        <script src="js/ajax_log_out.js"></script>
        <script src="plugin/datetime/src/DateTimePicker.js"></script>
        <script src="js/ajax_func.js"></script>
        <script src="dist/js/bootstrap.js"></script>
    </body>
</html>
