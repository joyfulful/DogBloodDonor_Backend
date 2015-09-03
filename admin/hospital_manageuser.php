<?php include "session.inc.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="../assets/datatables/media/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="../assets/css/admin.css" />
        <title>Manage Hospital Staff</title>
    </head>
    <body>
        <?php include "navbar.inc.php"; ?>
        <main>
            <div class="section" id="index-banner">
                <div class="container">
                   Manage Hospital Staff
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <ul class="tabs">
                        <?php
                        include "../dbcon.inc.php";
                        $res = $con->query("SELECT * FROM hospital");
                        while ($data = $res->fetch_assoc()) {
                            ?>
                            <li class="tab col s4"><a href="#group<?= $data["hospital_id"] ?>"><?= $data["hospital_nameeng"] ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <?php
                $res = $con->query("SELECT * FROM hospital");
                while ($data3 = $res->fetch_assoc()) {
                    $hospital_id = $data3["hospital_id"];
                    $res2 = $con->query("SELECT * FROM hospital h JOIN hospital_user hu ON h.hospital_id = hu.hospital_id WHERE h.hospital_id = '$hospital_id'");
                    ?>
                    <div id="group<?= $hospital_id ?>" class="col s12">
                        <div class="container">
                            <div class="row">
                                <br>
                                <h5><?= $data3["hospital_name"] ?></h5>
                                <table class="striped" id="datatables<?= $hospital_id ?>">
                                    <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>User Name</th>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Tel. Number</th>
                                            <th style="width:50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($data = $res2->fetch_assoc()) {
                                            ?>  
                                            <tr>
                                                <td><?= $data["hospital_userid"] ?></td>
                                                <td><?= $data["hospital_user"] ?></td>
                                                <td><?= $data["hospital_firstname"] ?> <?= $data["hospital_lastname"] ?></td>
                                                <td><?= $data["hospital_position"] ?></td>
                                                <td><?= substr($data["hospital_tel"],0,3)."-".substr($data["hospital_tel"],3,3)."-".substr($data["hospital_tel"],6) ?></td>
                                                <td>
                                                    <button class="btn blue smbtn editbtn" 
                                                            data-userid="<?= $data["hospital_userid"] ?>" data-user="<?= $data["hospital_user"] ?>" 
                                                            data-fname="<?= $data["hospital_firstname"] ?>" data-lname="<?= $data["hospital_lastname"] ?>" 
                                                            data-position="<?= $data["hospital_position"] ?>"
                                                            data-tel="<?= $data["hospital_tel"] ?>"
                                                            data-hos="<?= $data["hospital_name"] ?>">
                                                        <img src="../assets/img/pencilflat.png" style="height:17px; margin-bottom:3px;">
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div id="editmodal" class="modal">
                <div class="modal-content">
                    <h4>Edit Information for <span id="editshowusername"></span></h4>
                    <form class="col s12" action="hospital_manageuser_edit.php" method="post">
                        <input type="hidden" id="edituserid" name="userid">
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="editfname" name="fname" type="text" class="validate" required>
                                <label for="icon_prefix">First Name</label>
                            </div>
                            <div class="input-field col s6">
                                <input id="editlname" name="lname" type="text" class="validate" required>
                                <label for="icon_telephone">Last Name</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="editposition" name="position" type="text" class="validate" required>
                                <label for="icon_prefix">Position</label>
                            </div>
                            <div class="input-field col s6">
                                <input id="edittel" name="tel" type="text" class="validate" required>
                                <label for="icon_telephone">Tel Number</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix">perm_identity</i>
                                <input id="editusername" name="username" type="text" class="validate" readonly="" required>
                                <label for="username">User Name</label>
                            </div>
                            <div class="input-field col s6">
                                <input id="editpassword" name ="password" type="password" class="validate" >
                                ** If you don't want to change password, leave password field blank. 
                                <label for="password">Password</label>
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
        <script type="text/javascript" src="../assets/js/jquery.maskedinput.min.js"></script>
        <script>
            $(document).ready(function () {
                $("#navhospital").addClass("active");
                $("#navhospital_manageuser").addClass("active");
                $('.collapsible').collapsible();

                $("#datatables1").DataTable();
                $("#datatables2").DataTable();
                $("#datatables3").DataTable();


                $(".editbtn").on("click", function (e) {
                    $("#edituserid").val($(this).attr("data-userid"));

                    $("#editusername").val($(this).attr("data-user"));
                    $("#editusername").prev().addClass("active");
                    $("#editusername").next().addClass("active");
                    $("#editusername").addClass("active");
                    $("#editusername").addClass("vaild");
                    $("#editusername").focus();

                    $("#editfname").val($(this).attr("data-fname"));
                    $("#editfname").prev().addClass("active");
                    $("#editfname").next().addClass("active");
                    $("#editfname").addClass("active");
                    $("#editfname").addClass("vaild");
                    $("#editfname").focus();

                    $("#editlname").val($(this).attr("data-lname"));
                    $("#editlname").prev().addClass("active");
                    $("#editlname").next().addClass("active");
                    $("#editlname").addClass("active");
                    $("#editlname").addClass("vaild");
                    $("#editlname").focus();

                    $("#editposition").val($(this).attr("data-position"));
                    $("#editposition").prev().addClass("active");
                    $("#editposition").next().addClass("active");
                    $("#editposition").addClass("active");
                    $("#editposition").addClass("vaild");
                    $("#editposition").focus();

                    $("#edittel").val($(this).attr("data-tel"));
                    $("#edittel").prev().addClass("active");
                    $("#edittel").next().addClass("active");
                    $("#edittel").addClass("active");
                    $("#edittel").addClass("vaild");
                    $("#edittel").focus();
                    $("#edittel").mask("999-999-9999");

                    $("#editpassword").focus();

                    $('#editmodal').openModal();
                });
            });
        </script>
    </body>
</html>
