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
        <title>Tonhaikham</title>
        <link href="dist/css/bootstrap.css" rel="stylesheet">
        <link href="css/default.css" rel="stylesheet">
    </head>
    <body style="background-color: #E7E4E4;">

        <?
        include TEMPLATE_PATH . 'nav_bar_1.php';
        ?>

        <div class="container" style="background-color: white;">

            <div class="row" style="min-height: 400px;">
                <div class="col-lg-2" style="background-color: #3276B1;color: white;font-weight: bold;padding-left: 0px;padding-right: 0px;">
                    <div style="background-color: #222222;padding: 5px;color: white"> <span class="glyphicon glyphicon-info-sign"></span> Report</div>
                    <div style="border-bottom: 1px solid #E7E4E4;padding: 10px"><a style="color: white" href="report?page=income">Report Income</a></div>
                    <div style="border-bottom: 1px solid #E7E4E4;padding: 10px"><a style="color: white" href="report?page=popular_menu">Report Popular Menu</a></div>
                    <div style="border-bottom: 1px solid #E7E4E4;padding: 10px"><a style="color: white" href="report?page=menu_not_cook">Report Menu Can't Cook</a></div>
                    <div style="border-bottom: 1px solid #E7E4E4;padding: 10px"><a style="color: white" href="report?page=menu">Report Menu</a></div>
                    <div style="border-bottom: 1px solid #E7E4E4;padding: 10px"><a style="color: white" href="report?page=reservation">Report Table Reservation</a></div>
                </div>
                <div class="col-lg-10" >
                    <?
                    if (isset($_REQUEST['page'])) {
                        if (file_exists('./includes/templates/view/report_' . $_REQUEST['page'] . '.php')) {
                            include './includes/templates/view/report_' . $_REQUEST['page'] . '.php';
                        } else {
                            include './includes/templates/view/page_not_found.php';
                        }
                    } else {
                        echo "<div style='text-align:center'><br><br><h3>Welcome to report</h3><br><img src='img_project/Balance-icon.png'></div>";
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
            $(document).ready(function() {
                $("#dtBoxe").DateTimePicker();
                $("#dtBoxe2").DateTimePicker();
                $("#btn_pdf_income").click(function() {
                    $(".box-preview-report").hide();
                    var start = $(".startTime1").val();
                    var end = $(".endTime1").val();
                    var bill_detail = "";
                    if ($(".ch_bill_detail").is(':checked')) {
                        bill_detail = "enable";
                    }

                    var link_preview = "generate_report.php?type=1&s=" + start + "&e=" + end + "&bill=" + bill_detail;
                    $(".box-preview-report").attr("src", link_preview);
                    $(".box-preview-report").show();
                });

                $("#btn_pdf_can_not_cook").click(function() {
                    $(".box-preview-report").hide();
                    var start = $(".startTime1").val();
                    var end = $(".endTime1").val();
                    var num_popular = $("#num_popular").val();
                    var order_by = $(".order_by").val();
                    var link_preview = "generate_report.php?type=2&s=" + start + "&e=" + end + "&num=" + num_popular + "&order=" + order_by;
                    $(".box-preview-report").attr("src", link_preview);
                    $(".box-preview-report").show();
                });

                $("#btn-can-not-cook").click(function() {
                    $(".box-preview-report").hide();
                    var start = $(".startTime1").val();
                    var end = $(".endTime1").val();
                    var link_preview = "generate_report.php?type=3&s=" + start + "&e=" + end;
                    $(".box-preview-report").attr("src", link_preview);
                    $(".box-preview-report").show();
                });

                $("#btn_pdf_reservation").click(function() {
                    var ch_reservation = [];
                    var start = $(".startTime1").val();
                    var end = $(".endTime1").val();
                    $("input:checkbox.ch_reservation:checked").each(function() {
                        ch_reservation.push($(this).val());
                    });
                    if (ch_reservation == "") {
                        alert("Choose Reservation!");
                    } else {
                          var link_preview = "generate_report.php?type=5&s=" + start + "&e=" + end+"&reservation="+ch_reservation;
                        $(".box-preview-report").attr("src", link_preview);
                        $(".box-preview-report").show();
                    }

                });

                $("#btn-pdf-menu").click(function() {
                    $(".box-preview-report").hide();
                    var ch_menu = [];
                    $("input:checkbox.ch_menu_cate:checked").each(function() {
                        ch_menu.push($(this).val());
                    });

                    var list_menu_status = $("#list_menu_status").val();
                    var list_menu_type = $("#list_menu_type").val();
                    var list_menu_order = $("#list_menu_order").val();
                    var show_img = $("#show_img").val();
                    if (ch_menu == "") {
                        alert("Choose Menu Category!");
                    } else {
                        var link_preview = "generate_report.php?type=4&menu_cate=" + ch_menu + "&list_menu_status=" + list_menu_status + "&list_menu_type=" + list_menu_type + "&list_menu_order=" + list_menu_order + "&show_img=" + show_img;
                        $(".box-preview-report").attr("src", link_preview);
                        $(".box-preview-report").show();
                    }




                });

            });
        </script>
        <script src="js/ajax_log_out.js"></script>
        <script src="dist/js/bootstrap.js"></script>
    </body>
</html>
