<?php include "session.inc.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="../assets/datatables/media/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="../assets/css/admin.css" />
        <title>Welcome</title>
    </head>
    <body>
        <?php include "navbar.inc.php"; ?>
        <main>
            <div class="section" id="index-banner">
                <div class="container">
                    Welcome
                </div>
            </div>
            <div id="userviewmodal">
                <div style="width:1000px; margin:0 auto;">
                    <table><tr><td style="width:500px;" valign="top">
                                <div class="row">
                                    <div class="col s11">
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
                $('.collapsible').collapsible();
                $("#datatables").DataTable();

                var userid = "<?= $_SESSION["userdata"]["user_id"] ?>";
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
                             if (item.dog_birthyear == "") {
                                doghtml += '<b>Birthyear : </b> - <br>';
                            } else {
                                doghtml += '<b>Birthyear : </b>' + item.dog_birthyear + '<br>';
                            }
                            if (item.dog_disease == "") {
                                doghtml += '<b>Disease : </b> -<br>';
                            } else {
                                doghtml += '<b>Disease : </b>' + item.dog_disease + '<br>';
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
                    }
                });
            });
        </script>
    </body>
</html>
