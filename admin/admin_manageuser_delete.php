<?php
include "session.inc.php";
include "../dbcon.inc.php";
$userid = $con->real_escape_string($_GET["userid"]);
$con->query("DELETE FROM admin WHERE admin_id= '$userid'");
?>
<script>
    document.location = "admin_manageuser.php";
    </script>