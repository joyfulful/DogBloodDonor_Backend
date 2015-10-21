<?php include "../../dbcon.inc.php"; ?>
<div id="container">
    <div id="chart_div"></div>
</div>
<script type="text/javascript" src="../../assets/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<link rel="stylesheet" href="../../assets/font/th-sarabun/fonts.css">
<style>
    html, body{
        margin:0;
        padding:0;
        font-family: "Conv_THSarabunNew";
    }
    .noresult{
        position: absolute;
        top:140px;
        left:40px;
        width:100%;
        text-align: center;
        z-index:2;
        font-size:35px;
        font-weight: bold;
    }
    #container{
        width:100%;
        height:600px;
        overflow: hidden;
    }
    #chart_div{
        width:115%;
        margin-left:-30px;
    }
</style>
<?php
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
    $countrequester = "SELECT count(request_id) FROM request WHERE request_id IN (SELECT request_id FROM donate WHERE donate_status IN (1,2)) "
            . "AND YEAR(request.created_time) = '$year' ";
    $countdonator = "SELECT count(donate_id) FROM donate WHERE donate_status = 1 AND YEAR(donate_date) = '$year'";
} else {
    $countrequester = "SELECT count(request_id) FROM request WHERE request_id IN (SELECT request_id FROM donate WHERE donate_status IN (1,2)) "
            . "AND YEAR(request.created_time) >= '$syear' "
            . "AND MONTH(request.created_time) >= '$smonth' "
            . "AND YEAR(request.created_time) <= '$year' "
            . "AND MONTH(request.created_time) <= '$month' ";
    $countdonator = "SELECT count(donate_id) FROM donate WHERE donate_status = 1 "
            . "AND YEAR(donate_date) >= '$syear' "
            . "AND MONTH(donate_date) >= '$smonth' "
            . "AND YEAR(donate_date) <= '$year' "
            . "AND MONTH(donate_date) <= '$month' ";
}
$requesterres = $con->query($countrequester);
$donatorres = $con->query($countdonator);
if ($requesterres->num_rows > 0) {
    $requestdata = $requesterres->fetch_array();
    $requestcount = $requestdata[0];
} else {
    $requestcount = 0;
}
if ($donatorres->num_rows > 0) {
    $donatordata = $donatorres->fetch_array();
    $donatorcount = $donatordata[0];
} else {
    $donatordata = 0;
}
?>

<script>
    google.load("visualization", "1", {packages: ["corechart"]});
    google.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'หมู่เลือดสุนัข');
        data.addColumn('number', 'เปอร์เซ็นการบริจาคเลือด');
        data.addColumn({type: 'string', role: 'style'});
        data.addColumn({type: 'string', role: 'annotation'})
        data.addRows([
<?php
$colorarr = ["#FDFD96", "#FF6961", "#DEA5A4", "#AEC6CF", "#CFCFC4", "#B39EB5", "#B19CD9", "#03C03C", "#F49AC2", "#779ECB", "#CB99C9", "#FFB347", "#C23B22", "#77DD77"];
echo "['Amount of requesters', " . $requestcount . ", 'color: " . $colorarr[0] . "', '" . $requestcount . "'],";
echo "['Amount of donors', " . $donatorcount . ", 'color: " . $colorarr[1] . "', '" . $donatorcount . "'],";
?>
        ]);

        var options = {
<?php
if ($selecttimerange == "yearly") {
    echo 'title: "Requester and Donor Comparison In ' . $year . '",';
} else if ($selecttimerange == "monthly") {
    if ($month == $smonth & $year == $syear) {
        echo 'title: "Requester and Donor Comparison In ' . date("F", strtotime("2000-$smonth-01")) . ' ' . $syear . '",';
    } else {
        echo 'title: "Requester and Donor Comparison Between ' . date("F", strtotime("2000-$smonth-01")) . ' ' . $syear . " to " . date("F", strtotime("2000-$month-01")) . ' ' . $year . '",';
    }
}
?>
            width: "10%",
            height: 600,
            legend: 'none',
            titleTextStyle: {color: '#5c5c5c', fontName: 'Conv_THSarabunNew', fontSize: '25'},
            vAxis: {minValue: 0, minValue:0, maxValue: 1, format: '', gridlines: {count: 5},
                textStyle: {color: 'black',
                    fontName: 'Conv_THSarabunNew',
                    fontSize: '25'},
                title: 'Amount of',
                titleTextStyle: {color: 'black',
                    fontName: 'Conv_THSarabunNew',
                    fontSize: '25'}
            },
            hAxis: {textStyle: {color: 'black',
                    fontName: 'Conv_THSarabunNew',
                    fontSize: '25'},
                title: '',
                titleTextStyle: {color: 'black',
                    fontName: 'Conv_THSarabunNew',
                    fontSize: '25'}
            }
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }

</script>


<?php

function percentFormat($str) {
    return sprintf('%0.2f', $str);
}
?>