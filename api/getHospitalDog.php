<?php

sleep(1);
session_start();
include "../dbcon.inc.php";
header('Content-Type: application/json');
$response = array("result" => 0);
$dogid = $con->real_escape_string($_POST["dogid"]);
$hospital_id = $_SESSION["userdata"]["hospital_id"];
$q = $con->query("SELECT * FROM hospital_dog NATURAL JOIN dog_breeds WHERE hospital_dogid = '$dogid' AND hospital_id = '$hospital_id'");
if ($q->num_rows == 1) {
    $data = $q->fetch_assoc();
    if ($data["status"] == "1") {
        $response = array(
            "result" => 1,
            "dogname" => $data["hospital_dogdonorname"],
            "donorname" => $data["hospital_donorname"],
            "bloodtype_id" => $data["bloodtype_id"],
            "breeds_id" => $data["breeds_id"],
            "breeds_name" => $data["breeds_name"]
        );
    } else {
        $response = array(
            "result" => 3,
            "dogname" => $data["hospital_dogdonorname"],
            "donorname" => $data["hospital_donorname"],
            "bloodtype_id" => $data["bloodtype_id"],
            "breeds_id" => $data["breeds_id"],
            "breeds_name" => $data["breeds_name"]
        );
    }
} else {
    $q2 = $con->query("SELECT * FROM hospital_dog WHERE hospital_dogid = '$dogid' AND hospital_id != '$hospital_id'");
    if ($q2->num_rows == 1) {
        $response = array("result" => 2);
    }
}
echo json_encode($response);
