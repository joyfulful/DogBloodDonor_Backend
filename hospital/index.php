<?php include "session.inc.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="../assets/css/admin.css" />
        <link rel="stylesheet" href="../assets/css/animate.css" />
        <title>Welcome</title>
    </head>
    <body>
        <?php include "../hospital/navbar.inc.php"; ?>
        <main>
            <div class="section" id="index-banner">
                <div class="container">
                    <?php
                    include "../dbcon.inc.php";
                    $hos_id = $_SESSION["userdata"]["hospital_id"];
                    $res = $con->query("SELECT * FROM hospital WHERE hospital_id = '$hos_id'");
                    $data = $res->fetch_assoc();
                    ?>
                    Welcome <?= $data["hospital_nameeng"] ?> Staff 
                </div>
            </div>
            <div class="container" style="margin-top: 10%; margin-left: 20%">
                 <div class="row">
                     <div class="col s5">
                         <img src="../assets/img/hospitalflat.png" class="circle responsive-img" style="background-color: #e0e0e0"/>
                     </div>
      <div class="col s12 m4">
          
                <h4>You are: <?php echo $_SESSION["userdata"]["hospital_user"]; ?></h4>
                <hr>
                <h5>First Name: <?php echo $_SESSION["userdata"]["hospital_firstname"]; ?></h5>
                <h5>Last Name: <?php echo $_SESSION["userdata"]["hospital_lastname"]; ?></h5>
                <!-- <h4>Hospital Name: อยากเพิ่มชื่อโรงพบาล โดยเอารหัส hospital_shortcode มาสร้างเงื่อนไขเเล้วทำการเเสดงชื่อโรงพยาบาลแบบเต็มๆ -->
            </div>
      </div>

                </div>
            <div id="notificationmodal" class="modal modal-fixed-footer">
                <div class="modal-content" style="position: static;">
                    <br><br><br>
                    <h4 style="margin:0 auto; text-align: center;">Loading...<br><br><br><br>
                        <div class="preloader-wrapper big active">
                            <div class="spinner-layer spinner-blue-only">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div><div class="gap-patch">
                                    <div class="circle"></div>
                                </div><div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>
                    </h4>
                </div>
                <div class="modal-footer">
                    <div class="row" style="margin-top:10px; height:20px;">
                        <div class="col s10">
                            <div id="check" style="margin-top:5px;">
                                <input type="checkbox" class="filled-in" id="filled-in-box"  required="" />
                                <label for="filled-in-box">Do not show notification for these blood(s) again.</label>
                            </div>
                            <div id="btnloader" style="display: none; height:20px; overflow: no-content;">
                                <div class="preloader-wrapper small active">
                                    <div class="spinner-layer spinner-blue-only">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div><div class="gap-patch">
                                            <div class="circle"></div>
                                        </div><div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>
                                </div>
                                &nbsp;&nbsp;Saving notification state, Please wait...
                            </div>
                        </div>

                        <div class="col s2">
                            <button class="btn waves-effect waves-green" id="notibtn" style="margin-top:5px;"><span id="btntext">Close</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </main>


        <script type="text/javascript" src="../assets/js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
        <script>
            var isCheck = false;
            $(document).ready(function () {
                $('.collapsible').collapsible();
                $("#navindex").addClass("active");
                $.ajax({
                    url: "ajax_getnotification.php",
                    type: "POST",
                    data: {},
                    dataType: "html",
                    success: function (data) {
                        if (data != "") {
                            $("#notibtn").attr("disabled", "disabled");
                            $('#notificationmodal').openModal();
                            setTimeout(function () {
                                $("#notibtn").removeAttr("disabled");
                                $(".modal-content").html(data);
                            }, 1000)
                        }
                    }
                });

                $("#filled-in-box").on("change", function (e) {
                    if ($(this).is(":checked")) {
                        $("#btntext").html("Close and Save");
                        isCheck = true;
                    } else {
                        $("#btntext").html("Close");
                        isCheck = false;
                    }
                });

                $("#notibtn").on("click", function (e) {
                    if (isCheck) {
                        $("#check").hide();
                        $("#btnloader").fadeIn(500);
                        $("#notibtn").attr("disabled", "disabled");
                        $.ajax({
                            url: "ajax_getnotification.php",
                            type: "POST",
                            data: {"ack": true},
                            dataType: "html",
                            success: function (data) {
                                setTimeout(function () {
                                    $('#notificationmodal').closeModal();
                                }, 1000);
                            }
                        });
                    } else {
                        $('#notificationmodal').closeModal();
                    }
                });
            });
        </script>
    </body>
</html>
