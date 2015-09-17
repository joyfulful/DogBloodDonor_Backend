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

$bloodtyperes = $con->query("SELECT * FROM blood_type");
$bloodtype = array();
$countsum = 0;
while ($bloodtypedata = $bloodtyperes->fetch_assoc()) {
    $bloodtype_id = $bloodtypedata["bloodtype_id"];
    $bloodtype_name = $bloodtypedata["bloodtype_name"];
    if ($selecttimerange == "yearly") {
        $findcountres = $con->query("SELECT count(donate.donate_id) FROM donate "
                . "JOIN user_dog ON donate.dog_id = user_dog.dog_id "
                . "WHERE user_dog.dog_bloodtype_id = '$bloodtype_id' "
                . "AND YEAR(donate.donate_date) = '$year' "
                . "AND donate.donate_status IN(1,2) ");
    } else if ($selecttimerange == "monthly") {
        $findcountres = $con->query("SELECT count(donate.donate_id) FROM donate "
                . "JOIN user_dog ON donate.dog_id = user_dog.dog_id "
                . "WHERE user_dog.dog_bloodtype_id = '$bloodtype_id' "
                . "AND YEAR(donate.donate_date) = '$year' "
                . "AND MONTH(donate.donate_date) = '$month' "
                . "AND donate.donate_status IN(1,2) ");
    }
    echo $con->error;
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
        data.addColumn('number', 'เปอร์เซ็นการบริจาคเลือด');
        data.addColumn({type: 'string', role: 'style'});
        data.addColumn({type: 'string', role: 'annotation'})
        data.addRows([
<?php
$colorarr = ["#FDFD96", "#FF6961", "#DEA5A4", "#AEC6CF", "#CFCFC4", "#B39EB5", "#B19CD9", "#03C03C", "#F49AC2", "#779ECB", "#CB99C9", "#FFB347", "#C23B22", "#77DD77"];
foreach ($bloodtype as $key => $value) {
    echo "['" . $value["bloodtype_name"] . "', " . ($value["count"] / $countsum) . ", 'color: " . $colorarr[$key] . "', '" . (($value["count"] / $countsum) * 100) . "%'],";
}
?>
        ]);

        var options = {
<?php
if ($selecttimerange == "yearly") {
    echo 'title: "Top Donated Dog Blood Type In ' . $year . '",';
} else if ($selecttimerange == "monthly") {
    echo 'title: "Top Donated Dog Blood Type In ' . date("F", strtotime("2000-$month-01")) . ', ' . $year . '",';
}
?>
            width: "10%",
            height: 600,
            legend: 'none',
            titleTextStyle: {color: '#5c5c5c', fontName: 'Conv_THSarabunNew', fontSize: '25'},
            vAxis: {minValue: 0, minValue:0, maxValue: 1, format: 'percent', gridlines: {count: 5},
                textStyle: {color: 'black',
                    fontName: 'Conv_THSarabunNew',
                    fontSize: '25'},
                title: 'Donataion Percentage',
                titleTextStyle: {color: 'black',
                    fontName: 'Conv_THSarabunNew',
                    fontSize: '25'}
            },
            hAxis: {textStyle: {color: 'black',
                    fontName: 'Conv_THSarabunNew',
                    fontSize: '25'},
                title: 'Dog Blood Type',
                titleTextStyle: {color: 'black',
                    fontName: 'Conv_THSarabunNew',
                    fontSize: '25'}
            }
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }

</script>