<?php
include "session.inc.php";
include "../dbcon.inc.php";
$userid = $con->real_escape_string($_GET["userid"]);
$con->query("DELETE FROM user WHERE user_id= '$userid'");
$con->query("DELETE FROM user_profile WHERE user_id= '$userid'");
$con->query("DELETE FROM user_dog WHERE user_id= '$userid'");
$con->query("DELETE FROM user_session WHERE user_id= '$userid'");
$con->query("DELETE FROM request WHERE from_user_id= '$userid'");
$con->query("DELETE FROM pm WHERE from_user_id= '$userid' OR to_user_id = '$userid'");
$con->query("DELETE FROM pm_read WHERE message_id NOT IN (SELECT message_id FROM pm);");
?>
<script>
    document.location = "user_manageuser.php";
</script>