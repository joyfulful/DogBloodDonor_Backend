<header>
    <ul id="slide-out" class="side-nav fixed">
        <li class="logo">
            <img src="../assets/img/dog/logo1.png" style="height:120px;">
        </li>
        <li id="navindex" class="bold">
            <a href="index.php" class="waves-effect waves-red">Main Page</a>
        </li>
        <li id="navuser" class="bold">
            <a href="user_profile.php" class="waves-effect waves-red">User</a>
        </li>
        
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <li class="bold">
                    <a id ="navhistory" class="collapsible-header  waves-effect waves-red">Dog History </a>
                    <div class="collapsible-body">
                        <ul>
                            <li id = "navhistory_donate"><a href="user_historydonate.php">Blood Donation</a></li>
                            <li id = "navhistory_request"><a href="user_historyrequests.php">Blood Requests</a></li>
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