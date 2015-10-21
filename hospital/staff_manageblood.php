<?php
include "session.inc.php";
if (!isset($_GET['type'])) {
    echo '<script>document.location = "staff_bloodtype.php";</script> ';
    die();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="../assets/datatables/media/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="../assets/css/admin.css" />
        <link rel="stylesheet" href="../assets/css/animate.css" />
        <title>Manage Blood</title>
    </head>
    <body>

        <?php include "navbar.inc.php"; ?>
        <main>
            <div class="section" id="index-banner">
                <div class="container">
                    Blood Type :  <?php
                    include "../dbcon.inc.php";
                    $res = $con->query("SELECT * FROM  blood_type  where bloodtype_id = '" . $con->real_escape_string($_GET['type']) . "'");
                    $data = $res->fetch_assoc();
                    echo $data["bloodtype_name"];
                    ?>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <br>
                    <table class="striped" id="datatables">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Dog Name</th>
                                <th>Owner Name</th>
                                <th>Volume</th>
                                <th>PCV</th>
                                <th>Status</th>
                                <th>Expired Date</th>
                                <th>Updated By</th>
                                <th style="width:100px;"> </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            $notificationloop = array(
                                //expried !!!
                                array(
                                    "query" => " AND hb.exp_date < now()",
                                    "trclass" => "redtext",
                                    "before" => "<b>",
                                    "after" => "</b>",
                                    "stocktext" => "(Expried!)",
                                    "isdelete" => true
                                ),
                                //1 week query
                                array(
                                    "query" => " AND hb.exp_date BETWEEN now() AND DATE_ADD(now(), INTERVAL 1 WEEK);",
                                    "trclass" => "red lighten-4",
                                    "before" => "<b>",
                                    "after" => "</b>",
                                    "stocktext" => "",
                                    "isdelete" => false
                                ),
                                // 1 month query with out 1 week data
                                array(
                                    "query" => " AND hb.exp_date BETWEEN DATE_ADD(now(), INTERVAL 1 WEEK) AND DATE_ADD(now(), INTERVAL 1 MONTH);",
                                    "trclass" => "orange lighten-4",
                                    "before" => "<b>",
                                    "after" => "</b>",
                                    "stocktext" => "",
                                    "isdelete" => false
                                ),
                                //normal query
                                array(
                                    "query" => " AND hb.exp_date > DATE_ADD(now(), INTERVAL 1 MONTH);",
                                    "trclass" => "",
                                    "before" => "",
                                    "after" => "",
                                    "stocktext" => "",
                                    "isdelete" => false
                                )
                            );
                            foreach ($notificationloop as $key => $notidata) {
                                include "../dbcon.inc.php";
                                $res = $con->query("SELECT * FROM hospital_bloodstore hb "
                                        . "JOIN hospital_user hu on hu.hospital_userid = hb.hospitaluser_id "
                                        . "JOIN hospital_dog hd on hd.hospital_dogid = hb.hospital_dogid "
                                        . "JOIN blood_type bt on hd.bloodtype_id = bt.bloodtype_id "
                                        . "where hd.bloodtype_id = '" . $con->real_escape_string($_GET['type']) . "' "
                                        . "and hu.hospital_user LIKE '" . substr($_SESSION["userdata"]["hospital_user"], 0, 2) . "%' "
                                        . "and hb.status = 1" . $notidata["query"]);
                                echo $con->error;
                                while ($data = $res->fetch_assoc()) {
                                    ?>
                                    <tr class="<?= $notidata["trclass"] ?>">
                                        <td  data-sort="<?= $count++ ?>"><?= $data["bloodstore_id"] ?></td>
                                        <td><?= $data["bloodtype_name"] ?></td>
                                        <td><?= $data["hospital_dogdonorname"] ?> 
                                        <td><?= $data["hospital_donorname"] ?></td>
                                        <td><?= $data["volume"] ?> CC.</td>
                                        <td> <?= $data["pcv"] ?> %</td>
                                        <td> <?= ($data["status"] == "1" ? "In Stock" : "Used") . " " . $notidata["stocktext"] ?></td>
                                        <td> <?= $notidata["before"] . date("j M Y", strtotime($data["exp_date"])) . $notidata["after"] ?></td>
                                        <td> <?= $data["hospital_user"] ?></td>
                                        <td>
                                            <?php if ($notidata["isdelete"]) { ?>
                                                <button class="btn red smbtn delbtn" style="margin-top:-5px; padding-left:8px; padding-right:8px;"
                                                        data-bloodstoreid="<?= $data["bloodstore_id"] ?>" 
                                                        data-bloodtypename="<?= $data["bloodtype_name"] ?>" 
                                                        data-dogdonorname="<?= $data["hospital_dogdonorname"] ?>" 
                                                        data-donorname="<?= $data["hospital_donorname"] ?>" 
                                                        data-volume="<?= $data["volume"] ?>" 
                                                        data-pcv="<?= $data["pcv"] ?>">
                                                        <i class="material-icons">delete</i> 
                                                </button>
                                            <?php } else { ?>
                                                <button class="btn red smbtn usebtn" style="margin-top:-5px; padding-left:8px; padding-right:8px;"
                                                        data-bloodstoreid="<?= $data["bloodstore_id"] ?>" 
                                                        data-bloodtypename="<?= $data["bloodtype_name"] ?>" 
                                                        data-dogdonorname="<?= $data["hospital_dogdonorname"] ?>" 
                                                        data-donorname="<?= $data["hospital_donorname"] ?>" 
                                                        data-volume="<?= $data["volume"] ?>" 
                                                        data-pcv="<?= $data["pcv"] ?>"> 
                                                    USE
                                                </button>
                                            <?php } ?>
                                            <button class="btn blue smbtn editbtn" style="margin-top:-5px; padding-left:10px; padding-right:10px; " 
                                                    data-bloodstoreid="<?= $data["bloodstore_id"] ?>" 
                                                    data-volume="<?= $data["volume"] ?>" 
                                                    data-pcv="<?= $data["pcv"] ?>">
                                                    <img src="../assets/img/pencilflat.png" style="height:19px; margin-bottom:4px;"> 
                                            </button>
                                        </td>
                                    </tr>
                                    <?php
                                } //end while fetch assoc loop 
                            }//end notiloop
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>

            <div id="usemodal" class="modal">
                <div class="modal-content">
                    <div class="card-panel" style="background-color: #990000;color: white">
                        <h4 id="usetext"></h4>




                        <h5>Blood Information</h5><hr>
                        <p style="font-size: 100%; margin-left: 10%">
                            Blood ID : <span id="usebloodid"></span><br>
                            Blood Type : <span id="usebloodtype"></span><br>
                            Dog DonorName : <span id="usedogdonorname"></span><br>
                            Donor Name : <span id="usedonorname"></span><br>
                            Volume: <span id ="usevolume"></span> CC.<br>
                            PCV: <span id ="usepcv"></span> %<br>

                            <br>
                            <input type="checkbox" class="filled-in" id="filled-in-box"  required="" />
                            <label for="filled-in-box" id="usetext2"></label>
                        </p>
                    </div>
                </div>
                <div class="modal-footer" >

                    <button  id = "yesbtn" class="btn green right "  style="margin-right: 30px" disabled="">Yes</button> 
                    <a href="#!" class ="modal-close btn red " style="margin-right: 50px">No</a> 
                </div>
            </div>


        </div>

        <div id="editmodal" class="modal">
            <div class="modal-content">
                <h4>Edit Information</h4>
                <form class="col s12" id="editform" action="staff_manageblood_edit.php" method="post" novalidate>
                    <input type="hidden" id="editbloodstoreid" name="bloodstore_id">
                    <div class="row">
                        <div class="input-field col s5">
                            <i class="material-icons prefix"><img src = "../assets/img/volumeicon .png" width="35px"></i>
                            <input id="editvolume" name ="volume" type="number" class="validate" >

                            <label for="volume">Volume</label>
                        </div>
                        <div class="col s1" > 
                            <div style="margin-top: 25px">CC.</div>
                        </div>
                        <div class="input-field col s5">
                            <i class="material-icons prefix"></i>
                            <input id="editpcv" name="pcv" type="number" step="0.01" value="0.00" max="100.00" class="validate" required>
                            <label for="pcv">PCV</label>
                        </div>
                        <div class="col s1" > 
                            <div style="margin-top: 25px"> % </div>
                        </div>

                    </div>
                    <div class="row ">
                        <button type="submit" class="btn orange right">Save</button>
                        <a href="#!" class="modal-action modal-close waves-effect waves-red btn blue ">Back</a>
                    </div>
                </form>

            </div>
        </div>


    </main>

    <script type="text/javascript" src="../assets/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="../assets/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
    <script>
        var link = "#";
        var isCheck = false;
        $(document).ready(function () {
            $("#navhospital").addClass("active");
            $("#navhospital_manageblood").addClass("active");
            $('.collapsible').collapsible();
            $("#datatables").DataTable();

            $("#editform").on("submit", function (e) {
                var pcv = parseFloat($("#editpcv").val());
                var vol = parseFloat($("#editvolume").val());
                if (vol <= pcv) {
                    alert("Error : Blood Volume amount (" + vol + " cc.) should greater than PCV value (" + pcv + " %)\nPlease change the values before try saving again.");
                    e.preventDefault();
                    return false;
                }
            });

            $("#datatables").on("click", ".usebtn",function (e) {
                $("#usetext").html("Are you sure to use blood  ?");
                $("#usetext2").html("Please check for confirm use blood");
                $("#usebloodid").html($(this).attr("data-bloodstoreid"));
                $("#usebloodtype").html($(this).attr("data-bloodtypename"));
                $("#usedogdonorname").html($(this).attr("data-dogdonorname"));
                $("#usedonorname").html($(this).attr("data-donorname"));
                $("#usevolume").html($(this).attr("data-volume"));
                $("#usepcv").html($(this).attr("data-pcv"));
                link = "staff_manageblood_use.php?bloodstore_id=" + $(this).attr("data-bloodstoreid");
                $("#filled-in-box").prop('checked', false);
                $("#yesbtn").attr("disabled", "disabled");
                isCheck = false;
                $('#usemodal').openModal();
            });

            $("#datatables").on("click", ".delbtn",function (e) {
                $("#usetext").html("Are you sure to delete the expired blood  ?");
                $("#usetext2").html("Please check to confirm delete the expired blood");
                $("#usebloodid").html($(this).attr("data-bloodstoreid"));
                $("#usebloodtype").html($(this).attr("data-bloodtypename"));
                $("#usedogdonorname").html($(this).attr("data-dogdonorname"));
                $("#usedonorname").html($(this).attr("data-donorname"));
                $("#usevolume").html($(this).attr("data-volume"));
                $("#usepcv").html($(this).attr("data-pcv"));
                link = "staff_manageblood_use.php?bloodstore_id=" + $(this).attr("data-bloodstoreid") + "&isexpried=true";
                $("#filled-in-box").prop('checked', false);
                $("#yesbtn").attr("disabled", "disabled");
                isCheck = false;
                $('#usemodal').openModal();
            });

            $(".editbtn").on("click", function (e) {
                $("#editbloodstoreid").val($(this).attr("data-bloodstoreid"));
                $("#editvolume").val($(this).attr("data-volume"));
                $("#editvolume").prev().addClass("active");
                $("#editvolume").next().addClass("active");
                $("#editvolume").addClass("active");
                $("#editvolume").addClass("vaild");
                $("#editvolume").focus();
                $("#editpcv").val($(this).attr("data-pcv"));
                $("#editpcv").prev().addClass("active");
                $("#editpcv").next().addClass("active");
                $("#editpcv").addClass("active");
                $("#editpcv").addClass("vaild");
                $("#editpcv").focus();


                $('#editmodal').openModal();
            });
            $("#filled-in-box").on("change", function (e) {
                if ($(this).is(":checked")) {
                    $("#yesbtn").removeAttr("disabled");
                    isCheck = true;
                } else {
                    $("#yesbtn").attr("disabled", "disabled");
                    isCheck = false;
                }
            });
            $("#yesbtn").on("click", function (e) {
                if (isCheck) {
                    document.location = link;

                }
            });


        });
    </script>
</body>
</html>
