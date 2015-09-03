<?php
include "session.inc.php";
include "../dbcon.inc.php";
$bloodstore_id = $con->real_escape_string($_POST["bloodstore_id"]);
$volume = $con->real_escape_string($_POST["volume"]);
$pcv = $con->real_escape_string($_POST["pcv"]);

$con->query("UPDATE `hospital_bloodstore` SET `volume`= '$volume',
        `pcv`= '$pcv' WHERE "
        . " bloodstore_id = '$bloodstore_id' ");

$res = $con->query("SELECT hd.bloodtype_id FROM hospital_bloodstore hb "
        . "JOIN hospital_dog hd ON hd.hospital_dogid = hb.hospital_dogid "
        . " WHERE hb.bloodstore_id = '$bloodstore_id'");

echo $con->error;
$data = $res->fetch_array();
$return = $data[0];
//echo "return".$return;
?>
<script>
    document.location = "staff_manageblood.php?type=<?= $return ?>";
</script>