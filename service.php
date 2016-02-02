<?
require_once('includes/config.inc.php');
login_checker(array(1, 2, 3, 4));

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
    </head>
    <!-- NAVBAR
    ================================================== -->
    <body style="background-image: url('img_project/bg.jpg');background-size: cover;background-repeat: no-repeat ">

        <div class="navbar-wrapper">
            <!--<div class="container">-->

            <div class="navbar navbar-inverse navbar-static-top">
                <div class="container">
                    <ul class="nav navbar-nav">
                        <li><a href="backoffice.php" style="color: yellow"><b><span class="glyphicon glyphicon-tree-conifer"></span> Tonhaikham</b></a></li>
      
                       
                       <?
                        if (in_array($sys_user_role, array(1, 2, 4))) { // waiter,cashier,owner
                            echo ' <li><a href="serve.php"> <b>Serve</b></a></li>';
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

            <!--</div>-->
        </div>




        <!-- Marketing messaging and featurettes
        ================================================== -->
        <!-- Wrap the rest of the page in another container to center all the content. -->

        <div class="container">
            <div class="row" style="min-height: 400px;text-align: center"><br><br><br>
                <h1 style="color: white">Welcome to service </h1><br>
                <img src="img_project/service.png">
            </div>


        </div><!-- /.container -->

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
