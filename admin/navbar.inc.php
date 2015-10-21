<header>
    <ul id="slide-out" class="side-nav fixed">
        <li class="logo">
            <a href="index.php"> <img src="../assets/img/dog/logo1.png" style="height:120px;"></a>
        </li>
        <li id="navindex" class="bold">
            <a href="index.php" class="waves-effect waves-red">Main Page</a>
        </li>
        <li id="navuser" class="bold">
            <a href="user_manageuser.php" class="waves-effect waves-red">User</a>
        </li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <li class="bold">
                    <a id="navhospital" class="collapsible-header waves-effect waves-red">Hospital Staff</a>
                    <div class="collapsible-body">
                        <ul>
                            <li id="navhospital_adduser"><a href="hospital_adduser.php">Add Hospital Staff</a></li>
                            <li id="navhospital_manageuser"><a href="hospital_manageuser.php">Manage Hospital Staff</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <li class="bold">
                    <a id ="navadmin" class="collapsible-header  waves-effect waves-red">Admin</a>
                    <div class="collapsible-body">
                        <ul>
                            <li id = "navadmin_adduser"><a href="admin_adduser.php">Add Admin</a></li>
                            <li id ="navadmin_manageuser"><a href="admin_manageuser.php">Manage Admin</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <li class="bold">
                    <a id="navarticle" class="collapsible-header  waves-effect waves-red">Article</a>
                    <div class="collapsible-body">
                        <ul>
                            <li id="navarticle_add"><a href="article_add.php">Add New Article</a></li>
                            <li id="navarticle_manage"><a href="article_manage.php">Manage Article</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <li class="bold">
                    <a id="navreport" class="collapsible-header  waves-effect waves-red">Report</a>
                    <div class="collapsible-body">
                        <ul>
                            <li id="navreport_pdf"><a href="report_pdf.php">PDF Report</a></li>
                            <li id="navreport_csv"><a href="report_csv.php">CSV Report</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <li id="navlogout" class="bold">
            <a href="../api/logout.php" class="waves-effect waves-red">Logout</a>
        </li>
    </ul>
</header>