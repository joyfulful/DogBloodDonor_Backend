<?php

sleep(1);
header('Content-Type: application/json');
include "../dbcon.inc.php";
if (isset($_POST["newbreeds"])) {
    //add new breeds
    $breeds = $con->real_escape_string($_POST["newbreeds"]);
    $con->query("INSERT INTO `dog_breeds`(`breeds_id`, `breeds_name`) VALUES (null,'$breeds')");
    $response = array("breeds_id"=>$con->insert_id, "breeds_name" =>$breeds);
} else {
    $search = $con->real_escape_string($_POST["searchtext"]);
    $q = $con->query("SELECT * FROM dog_breeds WHERE breeds_name like '%$search%'");
    $response = array();
    while ($data = $q->fetch_assoc()) {
        array_push($response, $data);
    }
}
echo json_encode($response);
