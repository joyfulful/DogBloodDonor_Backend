<?php
include "session.inc.php";
include "../dbcon.inc.php";
$userid = $con->real_escape_string($_GET["id"]);
$res = $con->query("SELECT group_id FROM article_data WHERE article_id='$userid'");
$data = $res->fetch_array();
$group_id = $data[0];
$con->query("DELETE FROM article_data WHERE article_id= '$userid'");
?>
<script>
    document.location = "article_manage.php#group<?=$group_id?>";
    </script>