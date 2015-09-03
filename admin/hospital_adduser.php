<?php include "session.inc.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="../assets/css/admin.css" />
        <title>Add New Hospital Staff</title>
    </head>
    <body>
        <?php include "navbar.inc.php"; ?>
        <main>
            <div class="section" id="index-banner">
                <div class="container">
                    Add New Hospital Staff
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <br><br>
                    <form class="col s12" action="hospital_adduser_save.php" method="post">
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="icon_prefix" name="fname" type="text" class="validate" required>
                                <label for="icon_prefix">First Name</label>
                            </div>
                            <div class="input-field col s6">
                                <input id="icon_telephone" name="lname" type="text" class="validate" required>
                                <label for="icon_telephone">Last Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix"><img src="../assets/img/pin56.png" style="width:30px;"></i>
                                <input id="icon_prefix" name="postion" type="text" class="validate" required>
                                <label for="username">Position</label>
                            </div>
                            <div class="input-field col s6">
                                <i class="material-icons prefix"><img src="../assets/img/phone72.png" style="width:30px;"></i>
                                <input id="tel" name ="tel" type="text" class="validate" required>
                                <label for="tel">Tel</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <table>
                                    <tr>
                                        <td valign="top" style="width:30px;">
                                            <img src="../assets/img/hospitalflat.png" style="width:40px;">
                                        </td>
                                        <td>
                                            <div class="input-field col s12" >
                                                <select id="hospital" name ="hospital" required>
                                                    <option value="" disabled selected>Select Hospital</option>
                                                    <?php
                                                    include "../dbcon.inc.php";
                                                    $res = $con->query("SELECT * FROM hospital");
                                                    while ($data = $res->fetch_assoc()) {
                                                        ?>
                                                        <option value="<?= $data["hospital_shortcode"] ?>"><?= $data["hospital_name"] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <label>Select Hospital</label>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">perm_identity</i>
                                <input id="username" name="username" type="text" class="validate" readonly="" required>
                                <label for="username">User Name</label>
                            </div>

                        </div>


                        <div class="row ">
                            <div class="input-field col s6">
                                <i class="material-icons prefix">lock</i>
                                <input id="password" name ="password" type="password" class="validate" required>
                                <label for="password">Password</label>
                            </div>
                            <div class="input-field col s6">
                                <i class="material-icons prefix">lock</i>
                                <input id="conpassword" name ="conpassword" type="password" class="validate" required ">
                                       <label for="conpassword">Confirm Password</label>
                            </div>

                        </div>
                        <div class="row">
                            <div class="input-field col s12" style="color: red; text-align: right;" id ="errortext">

                            </div>
                        </div>
                        <div class="row">

                            <div class="input-field col s12">
                                <button   id="save"type="submit" class="btn orange right" disabled>Save</button>

                            </div>
                        </div>
                    </form>
                    </main>

                    <script type="text/javascript" src="../assets/js /jquery-2.1.4.min.js"></script>
                    <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
                    <script type="text/javascript" src="../assets/js/jquery.maskedinput.min.js"></script>
                    <script>
                        $(document).ready(function () {

                            $("#navhospital").addClass("active");
                            $("#navhospital_adduser").addClass("active");
                            $('.collapsible').collapsible();
                            $("select").material_select();
                            $("#tel").mask("999-999-9999");
                            $("#hospital").on("change", function (e) {
                                var val = $(this).val();
                                $.ajax({
                                    url: "../api/getHospitalUser.php",
                                    type: "POST",
                                    data: {"hos": val},
                                    dataType: "html",
                                    success: function (data) {
                                        $("#username").val(data);
                                        $("#username").prev().addClass("active");
                                        $("#username").next().addClass("active");
                                        $("#username").addClass("active");
                                        $("#username").addClass("vaild");
                                    }
                                });
                            });

                            $("#conpassword").on("keyup", function (e) {
                                var password = $("#password").val();
                                var conpassword = $("#conpassword").val();
                                if (password.length <= conpassword.length) {
                                    if (password == conpassword) {
                                        $("#save").removeAttr("disabled");
                                        $("#errortext").html("");
                                    } else {
                                        $("#save").attr("disabled", "disabled");
                                        $("#errortext").html("Error : Password and Confirm Password mismatch !");
                                    }
                                }
                            });





                        });
                    </script>
                    </body>
                    </html>
