<?php

sleep(1);
session_start();
header('Content-Type: application/json');
include "../dbcon.inc.php";
$hospital_id = $_SESSION["userdata"]["hospital_id"];
$searchby = $con->real_escape_string($_POST["searchby"]);
$search = $con->real_escape_string($_POST["searchtext"]);
$q;
if ($searchby == "dogid") {
    $q = $con->query("SELECT * FROM hospital_dog NATURAL JOIN dog_breeds WHERE hospital_dogid = '$search' AND hospital_id = '$hospital_id'");
} else if ($searchby == "dogname") {
    $q = $con->query("SELECT * FROM hospital_dog NATURAL JOIN dog_breeds WHERE hospital_dogdonorname like '%$search%' AND hospital_id = '$hospital_id'");
} else if ($searchby == "ownername") {
    $q = $con->query("SELECT * FROM hospital_dog NATURAL JOIN dog_breeds WHERE hospital_donorname like '%$search%' AND hospital_id = '$hospital_id'");
}
$response = array();
while ($data = $q->fetch_assoc()) {
    array_push($response, $data);
}
echo json_encode($response);
