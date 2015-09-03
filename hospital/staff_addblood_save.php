<?php
include "session.inc.php";
include "../dbcon.inc.php";
$dogid = $con->real_escape_string($_POST["dogid"]);
$dogname = $con->real_escape_string($_POST["dogname"]);
$ownername = $con->real_escape_string($_POST["ownername"]);
$breeds = $con->real_escape_string(@$_POST["breeds_id"]);
$blood = $con->real_escape_string(@$_POST["blood"]);
$hospital_id = $_SESSION["userdata"]["hospital_id"];
$res = $con->query("SELECT * FROM hospital_dog WHERE hospital_dogid = '$dogid'");
if($res->num_rows == 0){
    $con->query("INSERT INTO hospital_dog(hospital_dogid,hospital_dogdonorname,hospital_donorname,breeds_id,bloodtype_id,hospital_id,status)"
            . " VALUES ('$dogid','$dogname','$ownername','$breeds','$blood','$hospital_id',1)");
}
$volume = $con->real_escape_string($_POST["volume"]);
$pcv = $con->real_escape_string($_POST["pcv"]);
$date = $con->real_escape_string($_POST["date"]);
$year = substr(date("Y")+543,2,3);
$hospitaluser_id = $_SESSION["userdata"]["hospital_userid"];
$status = 1;
$dateobj =  new DateTime($date);
$dateobj->add(new DateInterval("P1Y"));
$exp =  $dateobj->format("Y-m-d");
$queryUser = $con->query("INSERT INTO `hospital_bloodstore`(`bloodstore_id`, `lot_no`, `mfg_date`, `exp_date`, `volume`, `pcv`, `hospital_dogid`, `status`,hospitaluser_id)"
        . " VALUES (null ,'$year',now(),'$exp','$volume', '$pcv' ,'$dogid','$status','$hospitaluser_id')");

$res = $con->query("SELECT * FROM hospital_dog WHERE hospital_dogid = '$dogid'");
$data = $res->fetch_assoc();
?>

<script>
    document.location = "staff_manageblood.php?type=<?=$data["bloodtype_id"]?>";
</script>