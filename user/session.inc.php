<?php
session_start();
if(!isset($_SESSION["role"])){
    echo "<script>alert('Please Login First'); document.location = '../index.php';</script>";
    die();
}else if($_SESSION["role"] != "user"){
    echo "<script>alert('You are not Allow to enter this page.'); document.location = '../".$_SESSION["role"]."';</script>";
    die();
}
?>