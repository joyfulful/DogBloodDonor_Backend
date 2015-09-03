<?php
include "session.inc.php";
include "../dbcon.inc.php";
$userid = $con->real_escape_string($_POST["userid"]);
$username = $con->real_escape_string($_POST["username"]);
$password = $con->real_escape_string($_POST["password"]);
 if ($password == ""){
 
 }else{
     $password = md5($password);
     $con->query ("UPDATE `admin` SET `admin_password`='$password' WHERE admin_id = '$userid'");
 }


?>
<script>
    document.location = "admin_manageuser.php";
    </script>