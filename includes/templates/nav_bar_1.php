<div class="navbar-wrapper">
    <div class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <ul class="nav navbar-nav">
                <li><a href="backoffice.php" style="color: yellow"><b><span class="glyphicon glyphicon-tree-conifer"></span> Tonhaikham</b></a></li>
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