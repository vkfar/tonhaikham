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
        <link rel="shortcut icon" href="../../../assets/ico/favicon.png">
        <title>Tonhaikham</title>
        <link href="../dist/css/bootstrap.css" rel="stylesheet">
        <link href="../css/default.css" rel="stylesheet">
        <style>
            body {
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #eee;
            }

            .form-signin {
                background-color: white;
                border: 5px solid rgba(0,0,0,0.2);
                max-width: 450px;
                padding: 15px;
                margin: 0 auto;
            }
            .form-signin-heading{
                color: black;
                font-weight: bolder;
            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }
            .form-signin .checkbox {
                font-weight: normal;
            }
            .form-signin .form-control {
                position: relative;
                font-size: 16px;
                height: auto;
                padding: 10px;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            .form-signin .form-control:focus {
                z-index: 2;
            }
            .form-signin input[type="text"] {
                margin-bottom: 10px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
            .form-signin input[type="password"] {
                margin-bottom: 10px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
            #log_bx_loading{
                text-align: center;
                padding: 20px;
                color: red;
                font-size: 16px;
                font-weight: bolder;
            }

        </style>
    </head>
    <body style="background-color: #E7E4E4;background-image: url('../img_project/bg.JPG');background-size: cover;background-repeat: no-repeat ">

        <div class="container">

            <form class="form-signin">
                <h2 class="form-signin-heading">Install Tonhaikham Restaurant Management System</h2>
                <input type="text" class="form-control" id="txt_db" placeholder="DATABASE NAME" autofocus>
                <input type="text" class="form-control" id="txt_user" placeholder="DATABASE USER" autofocus>
                <input type="password" class="form-control" id="txt_pass" placeholder="DATABASE PASSWORD">
                <button class="btn btn-lg btn-primary btn-block" id="btn_install" type="button">Install</button>
                <div id="bx_loading"></div>
            </form>

        </div>

    </body>
   
    <script src="../js/jquery.js"></script>
     <script>
        $(function (){
      
          $("#btn_install").click(function (){
    
            var db = $("#txt_db").val();
            var user = $("#txt_user").val();
            var pass = $("#txt_pass").val();
            $.post("check_install.php",{db:db,user:user,pass:pass},function (data){
                alert(data);
            });
            
          });  
        });
    </script>
    <script src="../dist/js/bootstrap.js"></script>
</html>