<?php

include "session.inc.php";
include "../dbcon.inc.php";
$username = $con->real_escape_string($_POST["username"]);
$password = md5($con->real_escape_string($_POST["password"]));
$queryUser = $con->query("INSERT INTO `admin`(`admin_id`, `admin_username`, `admin_password`) VALUES (null,'$username','$password' )");

?>
<script>
    document.location = "admin_manageuser.php";
    </script>