<?php include "session.inc.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="../assets/datatables/media/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="../assets/css/admin.css" />
        <title>Manage User</title>
    </head>
    <body>
        <?php include "navbar.inc.php"; ?>
        <main>
            <div class="section" id="index-banner">
                <div class="container">
                    Manage User
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <br>
                    <table class="striped" id="datatables">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th style="width:10%">Registration Type</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Dog Name</th>
                                <th style="width:80px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../dbcon.inc.php";
                            $res = $con->query("SELECT * FROM user u JOIN user_profile up ON u.user_id = up.user_id");
                            while ($data = $res->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $data["user_id"] ?></td>
                                    <td>
                                        <?php if ($data["user_type"] == "ma") { ?>
                                            Email
                                        <?php } else { ?>
                                            Facebook
                                        <?php } ?>
                                    </td>
                                    <td><?= $data["firstname"] ?> <?= $data["lastname"] ?></td>
                                    <td><?= $data["email"] ?></td>                                         
                                    <td>
                                        <?php
                                        $res1 = $con->query("SELECT * FROM user_dog WHERE user_id = $data[user_id] AND dog_status = 1 ");
                                        $count = 0;
                                        $total = $res1->num_rows;
                                        $dog_name = "";
                                        while ($data2 = $res1->fetch_assoc()) {
                                            $dog_name .= $data2["dog_name"];
                                            if (++$count != $total)
                                                $dog_name .= ", ";
                                        } ?>
                                        <?=$dog_name?>
                                    </td>
                                    <td>
                                        <button class="btn red smbtn delbtn" 
                                                data-userid="<?= $data["user_id"] ?>"  
                                                data-usertype="<?= $data["user_type"] ?>"  
                                                data-name="<?= $data["firstname"] ?> <?= $data["lastname"] ?>" 
                                                data-email="<?= $data["email"] ?>"
                                                data-dogname="<?= $dog_name ?>">
                                                <i class="material-icons">delete</i> 
                                        </button>
                                        <button class="btn blue smbtn viewbtn" data-userid="<?= $data["user_id"] ?>">
                                            <i class="material-icons">search</i> 
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
                        <h4>Are you sure to delete ?</h4><br>
                        <h5>User</h5><hr>
                        <p style="font-size: 110%; margin-left: 10%">
                            User ID : <span id="delshowid"></span><br>
                            User Type : <span id = "delshowusertype"></span><br>
                            Name : <span id="delshowname"></span><br>
                            Email : <span id="delshowemail"></span><br>
                            Dog'Name : <span id="delshowdogname"></span><br>

                        </p>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" id="delyes" class="waves-effect waves-green btn-flat">Yes</a>
                        <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">No</a>
                    </div>
                </div>
            </div>

            <div id="viewmodal" >
                <div style="width:1000px; margin:0 auto;">
                    <button class="btn" id="userclosebtn" style="position: fixed; bottom:20px; right:40px;">Close</button>
                    <table><tr><td style="width:500px;" valign="top">
                                <div class="row">
                                    <div class="col s11">
                                        <div class="section" id="index-banner" style="font-size:40px; text-align: center;">
                                            User / Dog Information
                                        </div>
                                        <div class="card medium">
                                            <div class="card-image">
                                                <img id="userimg" src="../assets/img/noimg.png">
                                                <span class="card-title shownametitle"></span>
                                            </div>
                                            <div class="card-content">
                                                <b>Name : </b><span id="showname"></span><br>
                                                <b>Email : </b><span id="showemail"></span><br>
                                                <b>Telephone : </b><span id="showtel"></span><br>
                                                <b>Address : </b><span id="showaddress"></span><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="width:500px;">
                                <div id="showdog"></div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </main>

        <script type="text/javascript" src="../assets/js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="../assets/datatables/media/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
        <script>
            $(document).ready(function () {
                $("#navuser").addClass("active");
                $("#navuser_manageuser").addClass("active");
                $("#datatables").DataTable();
                
                $(".delbtn").on("click", function (e) {
                    $("#delshowid").html($(this).attr("data-userid"));
                    $("#delshowusertype").html($(this).attr("data-usertype"));
                    $("#delshowname").html($(this).attr("data-name"));
                    $("#delshowemail").html($(this).attr("data-email"));
                    $("#delshowdogname").html($(this).attr("data-dogname"));
                    $("#delyes").attr("href", "user_manageuser_delete.php?userid=" + $(this).attr("data-userid"));
                    $('#deletemodal').openModal();
                });
                
                $("#userclosebtn").on("click", function (e) {
                    $("#viewmodal").fadeOut(500);
                });
                $(".viewbtn").on("click", function (e) {
                    var userid = $(this).attr("data-userid");
                    $.ajax({
                        "url": "../api/getUserDetails.php",
                        "type": "POST",
                        "dataType": "JSON",
                        "data": {"userid": userid},
                        success: function (data) {
                            console.log(data);
                            $("#showdog").html("");
                            if (data.userdata.user_image == null | data.userdata.user_image == "") {
                                $("#userimg").attr("src", "../assets/img/noimg.png");
                            } else {
                                $("#userimg").attr("src", "https://dogblooddonor.in.th/api/userimage/" + data.userdata.user_image);
                            }
                            $(".shownametitle").html(data.userdata.firstname + " " + data.userdata.lastname);
                            $("#showname").html(data.userdata.firstname + " " + data.userdata.lastname);
                            $("#showemail").html(data.userdata.email);
                            $("#showtel").html(data.userdata.telno);
                            $("#showaddress").html(data.userdata.address.house_no + " " + data.userdata.address.subdistrict + " " + data.userdata.address.district
                                    + " " + data.userdata.address.province + " " + data.userdata.address.postcode);
                            $.each(data.dogdata, function (i, item) {
                                var doghtml = "";
                                doghtml += '<div class="card-panel" style="height:200px; width:500px; padding:0px;">';
                                doghtml += '<table style="margin:0; padding:0;">';
                                doghtml += '<tr>';
                                doghtml += '<td style="width:200px;">';
                                if (item.dog_image == "") {
                                    doghtml += '<img src="../assets/img/noimg.png" class="userdogimg">';
                                } else {
                                    doghtml += '<img src="https://dogblooddonor.in.th/api/dogimage/' + item.dog_image + '" class="userdogimg materialboxed">';
                                }
                                doghtml += '</td>';
                                doghtml += '<td align="left" valign="middle">';
                                doghtml += '<div style="text-align: left; padding-left:20px; width:100%; position: relative;">';
                                doghtml += '<b>Dog ID : </b>' + item.dog_id + '<br>';
                                doghtml += '<b>Name : </b>' + item.dog_name + '<br>';
                                doghtml += '<b>Breeds : </b>' + item.breeds_name + '<br>';
                                if (item.dog_gender == "m") {
                                    doghtml += '<b>Gender : </b>Male<br>';
                                } else {
                                    doghtml += '<b>Gender : </b>Female<br>';
                                }
                                doghtml += '<b>Blood Type : </b>' + item.dog_bloodtype_name + '<br>';
                                if (item.dog_disease == "") {
                                    doghtml += '<b>Blood Disease : </b> -<br>';
                                } else {
                                    doghtml += '<b>Blood Disease : </b>' + item.dog_disease + '<br>';
                                }
                                doghtml += '<b>Weight : </b>' + item.dog_weight + ' Kg<br>';
                                doghtml += '<div style="position:absolute; right:10px; bottom:5px; opacity: 0.6;">';
                               
                                doghtml += '</div>';
                                doghtml += '</div>';
                                doghtml += '</td>';
                                doghtml += '</tr>';
                                doghtml += '</table>';
                                doghtml += '</div>';
                                $("#showdog").append(doghtml);
                            });
                            $('.materialboxed').materialbox();
                            $("#viewmodal").fadeIn(500);
                        }
                    });
                });
            });
        </script>
    </body>
</html>
