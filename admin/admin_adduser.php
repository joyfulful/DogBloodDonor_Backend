<?php include "session.inc.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="../assets/css/admin.css" />
        <title>Add New Admin</title>
    </head>
    <body>
        <?php include "navbar.inc.php"; ?>
        <main>
            <div class="section" id="index-banner">
                <div class="container">
                    Add New Admin
                </div>
            </div>
            <div class="container" style="margin-top: 5%; margin-left: 30%">
                <div class="row">
                    <br><br>
                    <form class="col s12" action="admin_adduser_save.php" method="post">
                        <div class="row">
                            <div class="input-field col s6">

                                <i class="material-icons prefix">perm_identity</i>
                                <input id="username" name="username" type="text" class="validate"  required>
                                <label for="username">User Name</label>
                            </div> 

                        </div>
                        <div class = "row">
                            <div class="input-field col s6" >
                                <i class="material-icons prefix">lock_outline</i>
                                <input id="password" name ="password" type="password" class="validate" required >
                                <label for="password">Password</label>
                            </div>
                        </div>

                        <div class = "row">
                             <div class="input-field col s6">
                                <i class="material-icons prefix">lock</i>
                                <input id="conpassword" name ="conpassword" type="password" class="validate" required ">
                                       <label for="conpassword">Confirm Password</label>
                            </div>
                        </div>
                          <div class="row">
                            <div class="input-field col s12" style="color: red; text-align: center;" id ="errortext">

                            </div>
                        </div>
                        <br>
                        <div class="row ">
                            <div class="col s8">
                              <button   id="save"type="submit" class="btn orange right" disabled>Save</button>
                                <div>
                                </div>
                                </form>
                            </div>
                        </div>
                        </main>

                        <script type="text/javascript" src="../assets/js/jquery-2.1.4.min.js"></script>
                        <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
                        <script>
                            $(document).ready(function () {
                                $("#navadmin").addClass("active");
                                $("#navadmin_adduser").addClass("active");
                                $('.collapsible').collapsible();

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
