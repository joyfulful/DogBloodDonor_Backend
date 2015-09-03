<?php
include "session.inc.php";
include "../dbcon.inc.php";
$userid = $con->real_escape_string($_POST["userid"]);
$fname  = $con->real_escape_string($_POST["fname"]);
$lname = $con->real_escape_string($_POST["lname"]);
$username = $con->real_escape_string($_POST["username"]);
$password = $con->real_escape_string($_POST["password"]);
$position = $con->real_escape_string($_POST["position"]);
$tel = $con->real_escape_string($_POST["tel"]);
$tel = str_replace("-", "", $tel);
 if ($password == ""){
    $con->query ("UPDATE `hospital_user` SET `hospital_user`= '$username',`hospital_firstname`='$fname',`hospital_lastname`='$lname', "
            . "hospital_position = '$position', hospital_tel = '$tel' WHERE hospital_userid = '$userid'");
 }else{
     $password = md5($password);
     $con->query ("UPDATE `hospital_user` SET `hospital_user`= '$username',`hospital_password`='$password',`hospital_firstname`='$fname',"
             . "`hospital_lastname`='$lname' , hospital_position = '$position', hospital_tel = '$tel'"
             . " WHERE hospital_userid = '$userid'");
 }


?>
<script>
    document.location = "hospital_manageuser.php";
    </script>