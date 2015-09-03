<?php
include "session.inc.php";
include "../dbcon.inc.php";
$userid = $con->real_escape_string($_GET["userid"]);
$con->query("UPDATE `hospital_dog` SET status = 0 WHERE  hospital_dogid = '$userid'");
?>
<script>
    document.location = "staff_managedog.php";
    </script>
?>