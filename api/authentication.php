<?php
session_start();
header('Content-Type: application/json');
include "../dbcon.inc.php";
$type = $con->real_escape_string($_POST["type"]);
$response = array("result"=>0);
if($type == "mail"){
    $username = $con->real_escape_string($_POST["username"]);
    $password = $con->real_escape_string($_POST["password"]);
    $queryUser = $con->query("SELECT * FROM user u JOIN user_profile up on u.user_id = up.user_id "
            . "WHERE email = '$username' AND user_type = 'ma'");
    if($queryUser->num_rows > 0){
        //found email in user table
        $userdata = $queryUser->fetch_assoc();
        if(md5($password) == $userdata["password"]){
            //password true
            $response = array("result"=>1,"role"=>"user");
            $_SESSION["role"] = "user";
            $_SESSION["userdata"] = $userdata;
        }else{
            //password false
            $response = array("result"=>0);
        }
    }
    $queryHospital = $con->query("SELECT * FROM hospital_user WHERE hospital_user = '$username'");
    if($queryHospital->num_rows > 0){
        //found email in user table
        $userdata = $queryHospital->fetch_assoc();
        if(md5($password) == $userdata["hospital_password"]){
            //password true
            $response = array("result"=>1,"role"=>"hospital");
            $_SESSION["role"] = "hospital";
            $_SESSION["userdata"] = $userdata;
        }else{
            //password false
            $response = array("result"=>0);
        }
    }
    $queryAdmin = $con->query("SELECT * FROM admin WHERE admin_username = '$username'");
    if($queryAdmin->num_rows > 0){
        //found email in user table
        $userdata = $queryAdmin->fetch_assoc();
        if(md5($password) == $userdata["admin_password"]){
            //password true
            $response = array("result"=>1,"role"=>"admin");
            $_SESSION["role"] = "admin";
            $_SESSION["userdata"] = $userdata;
        }else{
            //password false
            $response = array("result"=>0);
        }
    }
    echo json_encode($response);
}else if($type == "fb"){
    $fbid = $con->real_escape_string($_POST["fbid"]);
    $queryUser = $con->query("SELECT * FROM user u JOIN user_profile up on u.user_id = up.user_id "
            . "WHERE user_fbid = '$fbid' AND user_type = 'fb'");
    if($queryUser->num_rows > 0){
        //found fbid in user table
            $response = array("result"=>1,"role"=>"user");
            $userdata = $queryUser->fetch_assoc();
            $_SESSION["role"] = "user";
            $_SESSION["userdata"] = $userdata;
        }
    echo json_encode($response);
}
?>