<?php

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=requestbreeds.csv');
$output = fopen('php://output', 'w');
include "../../dbcon.inc.php";
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
$smonth = @$_GET["smonth"];
$syear = @$_GET["syear"];
if ($selecttimerange == "yearly") {
    $start = (new DateTime($year . '-01-01'))->modify('first day of this month');
    $end = (new DateTime($year . '-12-31'))->modify('last day of this month');
} else {
    $start = (new DateTime($syear . '-' . $smonth . '-01'))->modify('first day of this month');
    $end = (new DateTime($year . '-' . $month . '-31'))->modify('last day of this month');
}
$interval = DateInterval::createFromDateString('1 month');
$period = new DatePeriod($start, $interval, $end);

$head = array("Report Type");
foreach ($period as $dt) {
    array_push($head,$dt->format("F") . " " . $dt->format("Y"));
}
fputcsv($output, $head);

$breedsres = $con->query("SELECT * FROM dog_breeds ORDER BY breeds_id");
while ($breeds = $breedsres->fetch_assoc()) {
    $breeds_id = $breeds["breeds_id"];
    $inneroutput = array(getStringBetween($breeds["breeds_name"]));
    foreach ($period as $dt) {
        $year = $dt->format("Y");
        $month = $dt->format("n");
        $findcount = $con->query("SELECT count(request.request_id) FROM request "
                . "JOIN user_dog ON request.for_dog_id = user_dog.dog_id "
                . "WHERE user_dog.breeds_id = '$breeds_id' "
                . "AND YEAR(request.created_time) = '$year' "
                . "AND MONTH(request.created_time) = '$month' "
                . "AND request_id IN "
                . "(SELECT request_id FROM donate WHERE donate_status IN(1,2)) ");
        if ($findcount->num_rows > 0) {
            $count = $findcount->fetch_array();
            array_push($inneroutput, $count[0]);
        } else {
            array_push($inneroutput, 0);
        }
    }
    fputcsv($output, $inneroutput);
}

function getStringBetween($str, $from = "(", $to = ")") {
    $sub = substr($str, strpos($str, $from) + strlen($from), strlen($str));
    return substr($sub, 0, strpos($sub, $to));
}

?>
