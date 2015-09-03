<?php
include "session.inc.php";
include "../dbcon.inc.php";
$olddogid = $con->real_escape_string($_POST["olddogid"]);
$dogid = $con->real_escape_string($_POST["dogid"]);
$dname = $con->real_escape_string($_POST["dogname"]);
$downername = $con->real_escape_string($_POST["downername"]);
$breeds = $con->real_escape_string($_POST["breeds_id"]);
$blood = $con->real_escape_string($_POST["blood"]);

if ($olddogid != $dogid) {
    //check if dogid is already exists
    $res = $con->query("SELECT * FROM hospital_dog WHERE hospital_dogid = '$dogid'");
    if ($res->num_rows == 1) {
        //dog id already have in db
        echo "<script>alert('Cannot edit Dog ID $olddogid to $dogid, beacuse the edited Dog ID $dogid is already exists.');</script>";
    } else {
        //dog id is not exists, then update it
        $con->query("UPDATE hospital_dog SET hospital_dogid = '$dogid' WHERE hospital_dogid = '$olddogid'");

        //update the rest table
        $con->query("UPDATE hospital_bloodstore SET hospital_dogid = '$dogid' WHERE hospital_dogid = '$olddogid'");

        //update other data
    $con->query("UPDATE `hospital_dog` SET `hospital_dogdonorname`='$dname',"
            . "`hospital_donorname`='$downername',`breeds_id`='$breeds',`bloodtype_id`='$blood'"
            . " WHERE hospital_dogid = '$dogid'");
    }
} else {
//if dog id isn't change, update other data from what we get from the form.
    $con->query("UPDATE `hospital_dog` SET `hospital_dogdonorname`='$dname',"
            . "`hospital_donorname`='$downername',`breeds_id`='$breeds',`bloodtype_id`='$blood'"
            . " WHERE hospital_dogid = '$dogid'");
}
?>
<script>
    document.location = "staff_managedog.php";
</script>