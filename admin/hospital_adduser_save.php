<?php

include "session.inc.php";
include "../dbcon.inc.php";
$fname = $con->real_escape_string($_POST["fname"]);
$lname = $con->real_escape_string($_POST["lname"]);
$hospital = $con->real_escape_string($_POST["hospital"]);
$username = $con->real_escape_string($_POST["username"]);
$tel = $con->real_escape_string($_POST["tel"]);
$tel = str_replace("-", "", $tel);
$postion = $con->real_escape_string($_POST["postion"]);
$password = md5($con->real_escape_string($_POST["password"]));
$findHosID = $con->query("SELECT * FROM hospital WHERE hospital_shortcode = '$hospital'");
$res = $findHosID->fetch_assoc();
$hospital_id = $res["hospital_id"];
$queryUser = $con->query("INSERT INTO `hospital_user`(`hospital_userid`, `hospital_user`, `hospital_password`, `hospital_firstname`, `hospital_lastname`, `hospital_position`, `hospital_tel`, `hospital_id`) "
        . "VALUES (null,'$username','$password','$fname','$lname','$postion','$tel','$hospital_id')");
?>
<script>
    document.location = "hospital_manageuser.php#group<?=$hospital_id?>";
    </script>