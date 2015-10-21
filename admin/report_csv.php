<?php include "./session.inc.php"; ?>
<?php include "../dbcon.inc.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="../assets/css/admin.css" />
        <title>Report</title>
    </head>
    <body>    
        <?php include "navbar.inc.php"; ?>
        <main>
            <div class="section" id="index-banner">
                <div class="container">
                    <h3>Report (CSV)</h3>
                </div>
            </div>
            <div class="container">
                <div class ="col s12" style="margin-top:30px; margin-bottom:20px;">
                    <div class="row">
                        <div  class="input-field col s2" style="text-align: right; margin-top:20px;" >
                            <h6 style="font-weight: bold"> Type of Report : </h6>
                        </div>
                        <div class="input-field col s5">
                            <select id="reporttype">
                                <option disabled selected>Select Type of Report</option>
                                <option value="requestbreeds">Requested Dog Breeds</option>
                                <option value="donatebreeds">Donated Dog Breeds</option>
                                <option value="requestblood">Requested Dog Blood</option>
                                <option value="donateblood">Donated Dog Blood</option>
                                <option value="requesteranddonor">Requester and Donor Comparison</option>
                            </select>
                        </div>
                        <div class="input-field col s3">
                            <select id="selecttimerange">
                                <option disabled selected>Select Time Range</option>
                                <option name="timerange" value="yearly">Yearly</option>
                                <option name="timerange" value="monthly">Monthly</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div id="selectstartmonth" style="display: none;">
                            <div class="input-field col s2" style="text-align: right; margin-top:20px;" >
                                <h6 style="font-weight: bold">Start Month : </h6>
                            </div>
                            <div class="input-field col s2">
                                <select id="selectstartmonthinput">
                                    <?php
                                    $currentmonth = date('F', time());
                                    for ($i = 1; $i <= 12; $i++) {
                                        $month = date('F', strtotime("2000-$i-01"));
                                        ?>
                                        <option <?= ($month == $currentmonth ? "selected" : "") ?> value="<?= $i ?>"><?= $month ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div id="selectstartyear" style="display: none;">
                            <div  class="input-field col s1" style="text-align: right; margin-top:20px;" >
                                <h6 style="font-weight: bold"> Year : </h6>
                            </div>
                            <div class="input-field col s2">
                                <select id="selectstartyearinput">
                                    <?php
                                    $currentyear = date("Y", time());
                                    for ($i = 4; $i >= 0; $i--) {
                                        ?>
                                        <option <?= ($currentyear - $i == $currentyear ? "selected" : "") ?>  value="<?= $currentyear - $i ?>"><?= $currentyear - $i ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="selectmonth" style="display: none;">
                            <div class="input-field col s2" style="text-align: right; margin-top:20px;" >
                                <h6 style="font-weight: bold">End Month : </h6>
                            </div>
                            <div class="input-field col s2">
                                <select id="selectmonthinput">
                                    <?php
                                    $currentmonth = date('F', time());
                                    for ($i = 1; $i <= 12; $i++) {
                                        $month = date('F', strtotime("2000-$i-01"));
                                        ?>
                                        <option <?= ($month == $currentmonth ? "selected" : "") ?> value="<?= $i ?>"><?= $month ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div id="selectyear" style="display: none;">
                            <div  class="input-field col s1" style="text-align: right; margin-top:20px;" >
                                <h6 style="font-weight: bold"> Year : </h6>
                            </div>
                            <div class="input-field col s2">
                                <select id="selectyearinput">
                                    <?php
                                    $currentyear = date("Y", time());
                                    for ($i = 4; $i >= 0; $i--) {
                                        ?>
                                        <option <?= ($currentyear - $i == $currentyear ? "selected" : "") ?>  value="<?= $currentyear - $i ?>"><?= $currentyear - $i ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="btn" id="exportbtn" 
                                style="display: none; margin-left:20px; margin-top:20px;">Export CSV</button>
                    </div>
                </div>
            </div>
            <script type="text/javascript" src="../assets/js/jquery-2.1.4.min.js"></script>
            <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
            <script>
                var currentyear, currentmonth;
                $(document).ready(function (e) {
                    currentmonth = $("#selectmonthinput").val();
                    currentyear = $("#selectyearinput").val();
                    $.each($("select"), function (i, select) {
                        $(select).addClass("browser-default");
                    });
                    $("#navreport").addClass("active");
                    $("#navreport_csv").addClass("active");
                    $('.collapsible').collapsible();

                    $("#selecttimerange").on("change", function (e) {
                        var select = $(this).val();
                        if (select == "yearly") {
                            $("#selectstartmonth").hide();
                            $("#selectstartyear").hide();
                            $("#selectmonth").hide();
                            $("#selectyear").show();
                            $("#exportbtn").show();
                            $("#previewbtn").show();
                            cleanEndTime();
                        } else if (select == "monthly") {
                            $("#selectstartmonth").show();
                            $("#selectstartyear").show();
                            $("#selectmonth").show();
                            $("#selectyear").show();
                            $("#exportbtn").show();
                            $("#previewbtn").show();
                            setEndTime();
                        }
                    });

                    $("#exportbtn").on("click", function (e) {
                        var reporttype = $("#reporttype").val();
                        var selecttimerange = $("#selecttimerange").val();
                        var smonth = $("#selectstartmonthinput").val();
                        var syear = $("#selectstartyearinput").val();
                        var month = $("#selectmonthinput").val();
                        var year = $("#selectyearinput").val();
                        document.location = "report/csv_"+ reporttype + ".php?year=" + year + "&month=" + month + "&smonth=" + smonth + "&syear=" + syear + "&selecttimerange=" + selecttimerange;
                    });

                    $("#selectstartmonthinput").on("change", function (e) {
                        setEndTime();
                    });

                    $("#selectstartyearinput").on("change", function (e) {
                        setEndTime();
                    });

                });

                function setEndTime() {
                    var startmonth = parseInt($("#selectstartmonthinput").val());
                    var startyear = parseInt($("#selectstartyearinput").val());
                    $.each($("#selectmonthinput").find("option"), function (i, option) {
                        if (parseInt($(option).attr("value")) < startmonth) {
                            $(option).attr("disabled", "disabled");
                        } else {
                            $(option).removeAttr("disabled");
                        }
                    });
                    $.each($("#selectyearinput").find("option"), function (i, option) {
                        $(option).removeAttr("disabled");
                        if (parseInt($(option).attr("value")) < startyear) {
                            $(option).attr("disabled", "disabled");
                        } else {
                            $(option).removeAttr("disabled");
                        }
                    });
                    $("#selectmonthinput").val(startmonth);
                    $("#selectyearinput").val(startyear);

                }

                function cleanEndTime() {
                    $.each($("#selectmonthinput").find("option"), function (i, option) {
                        $(option).removeAttr("disabled");
                    });
                    $.each($("#selectyearinput").find("option"), function (i, option) {
                        $(option).removeAttr("disabled");
                    });
                    $("#selectyearinput").val(currentyear);
                    $("#selectmonthinput").val(currentmonth);
                }
            </script>
    </body>
</html>
