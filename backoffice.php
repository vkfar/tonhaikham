<?
require_once('includes/config.inc.php');
// check user login
login_checker(array(1, 2, 3, 4));
//
// sesion user
$sys_user = $_SESSION["sess_user"];
$sys_user_id = $_SESSION["sess_user_id"];
$sys_user_role = $_SESSION["sess_user_role"];
///
///connect database
$database = new Database();
$database->openConnection();
////
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

        <!-- Bootstrap core CSS framework -->
        <link href="dist/css/bootstrap.css" rel="stylesheet">

        <style>
            .btn-box-sys{
                color: white;
                background-color: rgba(255,255,255,0.2);
                min-height: 160px;
                border: 1px solid rgba(0,0,0,0.5);
                text-align: center;
                cursor: pointer;
            }
            .btn-box-sys:hover{
                background-color: #FFFFFF;
                color: black;
            }
            .a_box_sys:hover{
                text-decoration: none;
                color: black;
            }
            .box-serviece{
                background-color: rgba(255,255,255,0.2);
                border: 1px solid rgba(0,0,0,0.5);
                margin-top: 50px;
                min-height: 160px;
            }
            .btn-box-sys2{
                background-color: rgba(0,0,0,0.2);
                padding: 5px;
                margin-bottom: 10px;           
            }
            .btn-box-sys2:hover{
                background-color: #FFFFFF;        
            }
            .btn-box-sys2 img{
                text-align: center;
                width: 80px;
            }
            .btn-box-sys2 h3{
                margin-top: 12px;
            }

        </style>
        <link href="css/default.css" rel="stylesheet">
    </head>
    <!-- NAVBAR
    ================================================== -->

    <body style="background-image: url('img_project/bg.JPG');background-size: cover;background-repeat: no-repeat ">
        <?
        include TEMPLATE_PATH . 'nav_bar_1.php';
        ?>

        <div class="container" >
            <div class="row" style="min-height: 200px;">
                <?
                $user_gird['1'] = "3"; // owner
                $user_gird['2'] = "3"; // cashier
                $user_gird['3'] = "5"; // COOK
                $user_gird['4'] = "5"; // waiter
                ?>
                <div class="col-lg-<?= $user_gird[$sys_user_role] ?>">
                </div>

                <?
                if (in_array($sys_user_role, array(1, 2))) {
                    ?>
                    <div class="col-lg-2 " style="margin-top: 50px;">
                        <a class="a_box_sys" href="main_manage.php">
                            <div class="btn-box-sys">
                                <h3>Manage Main</h3>
                                <br><img src="img_project/main.png">
                            </div>
                        </a>
                    </div>
                    <?
                }
                ?>
                <div class="col-lg-2" style="margin-top: 50px;">
                        <a class="a_box_sys" href="service.php">
                            <div class="btn-box-sys">
                                <h3>Service</h3>
                                <br><img src="img_project/service.png">
                            </div>
                        </a>
                    </div>
                <?
                if (in_array($sys_user_role, array(1, 2))) { // show only owner,cashier
                    ?>
                    <div class="col-lg-2" style="margin-top: 50px;">
                        <a class="a_box_sys" href="report.php">
                            <div class="btn-box-sys">
                                <h3>Report</h3>
                                <br><img src="img_project/Balance-icon.png">
                            </div>
                        </a>
                    </div>
                    <?
                }
                ?>
                <div class="col-lg-<?= $user_gird[$sys_user_role] ?>">

                </div>
            </div>




            <!-- /END THE FEATURETTES -->


            <!-- FOOTER -->


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


        <script src="js/ajax_log_out.js"></script>
        <script src="plugin/datetime/src/DateTimePicker.js"></script>
        <script src="dist/js/bootstrap.js"></script>
    </body>
</html>
