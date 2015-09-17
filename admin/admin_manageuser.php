<?php include "session.inc.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="../assets/datatables/media/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="../assets/css/admin.css" />
        <title>Manage Admin</title>
    </head>
    <body>
        <?php include "navbar.inc.php"; ?>
        <main>
            <div class="section" id="index-banner">
                <div class="container">
                    Manage Admin
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <br>
                    <table class="striped" id="datatables">
                        <thead>
                            <tr>
                                <th>Admin ID</th>
                                <th>Admin Name</th>
                                <th style="width:80px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../dbcon.inc.php";
                            $res = $con->query("SELECT * FROM admin ");
                            while ($data = $res->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $data["admin_id"] ?></td>
                                    <td><?= $data["admin_username"] ?></td>
                                    <td   style="text-align: right"  >
                                        <?php if($data['admin_id']!= $_SESSION['userdata']['admin_id']){ ?>
                                        <button class="btn red smbtn delbtn" style="margin-top:-5px;"
                                                data-userid="<?= $data["admin_id"] ?>" data-user="<?= $data["admin_username"] ?>" > 
                                            <i class="material-icons">delete</i>
                                        </button>
                                        <?php } ?>
                                        <button class="btn blue smbtn editbtn" 
                                                data-userid="<?= $data["admin_id"] ?>" data-user="<?= $data["admin_username"] ?>" > 
                                            <img src="../assets/img/pencilflat.png" style="height:17px; margin-bottom:3px;">
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
            <div id="deletemodal" class="modal">
                <div class="modal-content">
                    <div class="card-panel" style="background-color: #990000;color: white">
                    <h4>Are you sure to delete?</h4><br>
                    
                       <h5>Admin User</h5><hr>
                    <p style="font-size: 110%; margin-left: 10%">
                        User ID : <span id="delshowid"></span><br>
                        Username : <span id="delshowusername"></span><br>
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="#!" id="delyes" class="waves-effect waves-green btn-flat">Yes</a>
                    <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">No</a>
                </div>
                    </div>
            </div>

            <div id="editmodal" class="modal">
                <div class="modal-content">
                    <h4>Edit Information for <span id="editshowusername"></span></h4>
                    <form class="col s12" action="admin_manageuser_edit.php" method="post">
                        <input type="hidden" id="edituserid" name="userid">
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
        <script>
            $(document).ready(function () {
                $("#navadmin").addClass("active");
                $("#navadmin_manageuser").addClass("active");
                $('.collapsible').collapsible();
                $("#datatables").DataTable();
                $(".delbtn").on("click", function (e) {
                    $("#delshowid").html($(this).attr("data-userid"));
                    $("#delshowusername").html($(this).attr("data-user"));
                    $("#delyes").attr("href", "admin_manageuser_delete.php?userid=" + $(this).attr("data-userid"));
                    $('#deletemodal').openModal();
                });

                $(".editbtn").on("click", function (e) {
                    $("#edituserid").val($(this).attr("data-userid"));

                    $("#editusername").val($(this).attr("data-user"));
                    $("#editusername").prev().addClass("active");
                    $("#editusername").next().addClass("active");
                    $("#editusername").addClass("active");
                    $("#editusername").addClass("vaild");
                    $("#editusername").focus();
                    $("#editpassword").focus();

                    $('#editmodal').openModal();
                });
            });
        </script>
    </body>
</html>
