<?php include "../../dbcon.inc.php"; ?>
<div id="chart_div"></div>
<script type="text/javascript" src="../../assets/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<style>
    html, body{
        margin:0;
        padding:0;
    }
    .noresult{
        position: absolute;
        top:100px;
        left:0;
        width:1000px;
        text-align: center;
        z-index:2;
        font-size:25px;
        font-weight: bold;
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

$bloodtyperes = $con->query("SELECT * FROM blood_type");
$bloodtype = array();
$countsum = 0;
while ($bloodtypedata = $bloodtyperes->fetch_assoc()) {
    $bloodtype_id = $bloodtypedata["bloodtype_id"];
    $bloodtype_name = $bloodtypedata["bloodtype_name"];
    if ($selecttimerange == "yearly") {
        $findcountres = $con->query("SELECT count(request.request_id) FROM request "
                . "JOIN user_dog ON request.for_dog_id = user_dog.dog_id "
                . "WHERE user_dog.dog_bloodtype_id = '$bloodtype_id' "
                . "AND YEAR(request.created_time) = '$year' "
                . "AND request_id IN "
                . "(SELECT request_id FROM donate WHERE donate_status IN(1,2)) ");
    } else if ($selecttimerange == "monthly") {
        $findcountres = $con->query("SELECT count(request.request_id) FROM request "
                . "JOIN user_dog ON request.for_dog_id = user_dog.dog_id "
                . "WHERE user_dog.dog_bloodtype_id = '$bloodtype_id' "
                . "AND YEAR(request.created_time) = '$year' "
                . "AND MONTH(request.created_time) = '$month' "
                . "AND request_id IN "
                . "(SELECT request_id FROM donate WHERE donate_status IN(1,2)) ");
    }
    if ($findcountres->num_rows == 0) {
        $count = 0;
    } else {
        $data = $findcountres->fetch_array();
        $count = $data[0];
    }
    if ($count != "0") {
        $countsum += $count;
        array_push($bloodtype, array(
            "bloodtype_id" => $bloodtype_id,
            "bloodtype_name" => $bloodtype_name,
            "count" => $count
        ));
    }
}
usort($bloodtype, function($a, $b) {
    return $a['count'] - $b['count'];
});
$bloodtype = array_reverse($bloodtype);
?>

<?php
if (sizeof($bloodtype) == 0) {
    ?>
    <div class="noresult">
        <br><br><br>
        <?php
        if ($selecttimerange == "yearly") {
            echo 'No Data In ' . $year;
        } else if ($selecttimerange == "monthly") {
            echo 'No Data In ' . date("F", strtotime("2000-$month-01")) . ', ' . $year;
        }
        ?>
    </div>
    <?php
}
?>

<script>
    google.load("visualization", "1", {packages: ["corechart"]});
    google.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'หมู่เลือดสุนัข');
        data.addColumn('number', 'เปอร์เซ็นการขอเลือด');
        data.addRows([
<?php
foreach ($bloodtype as $key => $value) {
    echo "['" . $value["bloodtype_name"] . "', " . ($value["count"] / $countsum) . "],";
}
?>
        ]);

        var options = {
<?php
if ($selecttimerange == "yearly") {
    echo 'title: "Top Request Dog Blood Type In ' . $year . '",';
} else if ($selecttimerange == "monthly") {
    echo 'title: "Top Request Dog Blood Type In ' . date("F", strtotime("2000-$month-01")) . ', ' . $year . '",';
}
?>
            width: "100%",
            height: 600,
            legend: 'none',
            titleTextStyle: { color: '#5c5c5c', fontName: 'Conv_THSarabunNew', fontSize: '25' },
            vAxis: {maxValue: 1, format: 'percent', gridlines: {count: 5},
                    textStyle: { color: 'black', 
                   fontName: 'Conv_THSarabunNew', 
                   fontSize: '25' }},
           hAxis : {textStyle: { color: 'black', 
                   fontName: 'Conv_THSarabunNew', 
                   fontSize: '25' }}
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }

</script>