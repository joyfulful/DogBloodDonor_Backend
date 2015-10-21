<?php
session_start();
include "../../../dbcon.inc.php";

$reporttype = $_GET["reporttype"];

$checktypearr = array("toprequestbreeds", "topdonatebreeds", "toprequestblood", "topdonateblood","requesteranddonor");
if (!in_array($reporttype, $checktypearr)) {
    echo "<script>alert('ข้อมูลไม่ถูกต้อง กรุณาทำรายการใหม่อีกครั้ง');window.close();</script>";
    die();
}

if (isset($_GET["year"])) {
    $year = $con->real_escape_string($_GET["year"]);
} else {
    $year = date("Y", time());
}

if (isset($_GET["month"])) {
    $month = $con->real_escape_string($_GET["month"]);
} else {
    $month = date("n", time());
}

if (isset($_GET["selecttimerange"])) {
    $selecttimerange = $con->real_escape_string($_GET["selecttimerange"]);
} else {
    $selecttimerange = "yearly";
}

$syear = @$_GET["syear"];
$smonth = @$_GET["smonth"];

$user = $_SESSION["userdata"]["admin_username"];
$actual_link = "http://" . $_SERVER['HTTP_HOST'] . strtok($_SERVER["REQUEST_URI"], '?');
$url = $actual_link . "../render.php?year=" . $year . "&smonth=" . $smonth ."&syear=" . $syear ."&month=" . $month . "&selecttimerange=" . $selecttimerange . "&reporttype=" . $reporttype . "&user=" . $user;

$file = "pdfstorage/$reporttype-$selecttimerange.pdf";
$filename = "$reporttype-$selecttimerange.pdf";
$run = exec('"./phantomjs" --ignore-ssl-errors=true "createpdf.js" "' . $url . '" "' . $file . '"');
header('Content-Type: application/pdf');
//if (isset($_GET["download"])) {
//header("Content-Disposition:inline;filename='$filename'");
header("Content-Disposition:attachment;filename='$filename'");
//}
readfile($file);
unlink($file);
