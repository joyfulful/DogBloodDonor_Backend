<?php

include "session.inc.php";
include "../dbcon.inc.php";
$bloodstore_id = $con->real_escape_string($_GET["bloodstore_id"]);
$hospitaluser_id = $_SESSION["userdata"]["hospital_userid"];
if(isset($_GET["isexpried"])){
    $action = "E";
}else{
    $action = "U";
}
$con->query("INSERT INTO `hospital_bloodtransaction`(`bloodtrasaction_id`, `bloodstore_id`, `date_useblood`, `hospitaluser_useblood`, `action`)"
        . " VALUES (null,'$bloodstore_id',now(),'$hospitaluser_id','$action')");
$con->query("UPDATE hospital_bloodstore SET status =0 where bloodstore_id = '$bloodstore_id'");

$res = $con->query("SELECT hospital_dog.bloodtype_id FROM hospital_bloodstore "
        . "JOIN hospital_dog ON hospital_bloodstore.hospital_dogid = hospital_dog.hospital_dogid "
        . "WHERE hospital_bloodstore.bloodstore_id = '$bloodstore_id'");
$data = $res->fetch_array();
$return = $data[0];
?>

<script>
   document.location = "staff_manageblood.php?type=<?=$return?>";
</script>