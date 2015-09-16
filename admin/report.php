<?php include "session.inc.php"; ?>
<?php include "../dbcon.inc.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="../assets/css/admin.css" />
        <title>Report</title>
        <style>
        </style>

    </head>
    <body>    <?php include "navbar.inc.php"; ?>
        <main>
            <div class="section" id="index-banner">
                <div class="container">
                    <h3>Report</h3>
                </div>
            </div>
            <div class ="container col s12" style="margin-top:30px; margin-bottom:20px;">
                <div class="row">
                    <div  class="input-field col s3" style="text-align: right; ;" >
                        <h6> Type of Report : </h6>
                    </div>
                    <div class="input-field col s6">
                        <select>
                            <option>Top Requested Dog Breeds</option>
                            <option>Top Donated Dog Breeds</option>
                            <option>Top Requested Dog Blood</option>
                            <option>Top Donated Dog Blood</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class ="container col s12" style="margin-top:30px; margin-bottom:20px;">
                <div class="row">
                    <div class="input-field col s3" style="text-align: right;">
                        <h6> Select month of Report : </h6>
                    </div>
                    <div class="input-field col s6 " >
                        <select>
                            <option>January </option>
                            <option>February </option>
                            <option>March </option>
                            <option>April</option>
                            <option>May </option>
                            <option>June</option>
                            <option>July </option>
                            <option>August</option>
                            <option>September</option>
                            <option>October </option>
                            <option>November </option>
                            <option>December </option>
                        </select>
                    </div>
                    <div class="input-field col s2 offset-s1">
                        <button class="btn col s10">Export</button>
                    </div>
                </div>
            </div>
             <div class ="container col s12" style="margin-top:30px; margin-bottom:20px;">
                <div class="row">
                    <div class="input-field col s3" style="text-align: right;">
                        <h6> Select month of Year : </h6>
                    </div>
                    <div class="input-field col s6 " >
                        <select>
                            <option> 2015</option>
                            <option> 2016</option>
                           
                        </select>
                    </div>
                    <div class="input-field col s2 offset-s1">
                        <button class="btn col s10" disabled="">Export</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div id="chart_div"></div>

            </div>

            <script type="text/javascript" src="../assets/js/jquery-2.1.4.min.js"></script>
            <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
            <script type="text/javascript" src="https://www.google.com/jsapi"></script>
            <?php
            if (isset($_GET["year"])) {
                $currentyear = $con->real_escape_string($_GET["year"]);
            } else {
                $currentyear = date("Y", time());
            }
            $dogbreedsres = $con->query("SELECT * FROM dog_breeds");
            $dogbreeds = array();
            $countsum = 0;
            while ($dogbreedsdata = $dogbreedsres->fetch_assoc()) {
                $breeds_id = $dogbreedsdata["breeds_id"];
                $breeds_name = $dogbreedsdata["breeds_name"];
                $findcountres = $con->query("SELECT count(request.request_id) FROM request "
                        . "JOIN user_dog ON request.for_dog_id = user_dog.dog_id "
                        . "WHERE user_dog.breeds_id = '$breeds_id' "
                        . "AND YEAR(request.created_time) = '$currentyear'"
                        . "AND request_id IN "
                        . "(SELECT request_id FROM donate WHERE donate_status IN(1,2)) ");
                if ($findcountres->num_rows == 0) {
                    $count = 0;
                } else {
                    $data = $findcountres->fetch_array();
                    $count = $data[0];
                }
                if ($count != "0") {
                    $countsum += $count;
                    array_push($dogbreeds, array(
                        "breeds_id" => $breeds_id,
                        "breeds_name" => $breeds_name,
                        "count" => $count
                    ));
                }
            }
            usort($dogbreeds, function($a, $b) {
                return $a['count'] - $b['count'];
            });
            ?>
            <script>
                google.load("visualization", "1", {packages: ["corechart"]});
                google.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'สายพันธ์สุนัข');
                    data.addColumn('number', 'เปอร์เซ็นการขอเลือด');
                    data.addRows([
<?php
foreach ($dogbreeds as $key => $value) {
    echo "['" . $value["breeds_name"] . "', " . ($value["count"] / $countsum) . "],";
}
?>
                    ]);

                    var options = {
                        width: 1000,
                        height: 400,
                        legend: 'none',
                        vAxis: {format: 'percent', gridlines: {count: 10}}
                    };

                    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                }


                $(document).ready(function (e) {
                    $('select').material_select();
                    $("#navreport").addClass("active");
                });
            </script>


    </body>
</html>
