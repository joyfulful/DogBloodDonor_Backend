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
echo $con->error;
echo "INSERT INTO `hospital_bloodtransaction`(`bloodtrasaction_id`, `bloodstore_id`, `date_useblood`, `hospitaluser_useblood`, `action')"
        . " VALUES (null,'$bloodstore_id',now(),'$hospitaluser_id','$action')";
$con->query("UPDATE hospital_bloodstore SET status =0 where bloodstore_id = '$bloodstore_id'");

$res = $con->query("SELECT bloodtype_id FROM hospital_bloodstore NATURAL JOIN hospital_dog WHERE bloodstore_id = '$bloodstore_id'");
//echo $con->error;
$data = $res->fetch_array();
$return = $data[0];
//echo "return".$return;
?>

<script>
   document.location = "staff_manageblood.php?type=<?=$return?>";
</script>