<?php include "session.inc.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="../assets/datatables/media/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="../assets/css/admin.css" />
        <title>Edit Dog Information</title>
    </head>
    <body>
        <?php include "navbar.inc.php"; ?>
        <main>
            <div class="section" id="index-banner">
                <div class="container">
                    Edit Dog Information 
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <br>
                    <table class="striped" id="datatables">
                        <thead>
                            <tr>
                                <th>Dog ID</th>
                                <th>Dog Name</th>
                                <th>Owner Name</th>
                                <th>Breed</th>
                                <th>Blood Type</th>
                                <th style="width:100px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../dbcon.inc.php";
                            $hospital_id = $_SESSION["userdata"]["hospital_id"];
                            $res = $con->query("SELECT * FROM hospital_dog hd NATURAL JOIN blood_type bt NATURAL JOIN dog_breeds WHERE hospital_id = '$hospital_id' AND status = 1");
                            while ($data = $res->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $data["hospital_dogid"] ?></td>
                                    <td><?= $data["hospital_dogdonorname"] ?></td>
                                    <td><?= $data["hospital_donorname"] ?></td>
                                    <td><?= $data["breeds_name"] ?></td>
                                    <td><?= $data["bloodtype_name"] ?></td>   
                                    <td>
                                                   
                                        <button class="btn red smbtn delbtn" style="margin-top:-5px; padding-left:10px; padding-right:10px; "
                                                data-hospitaldogid="<?= $data["hospital_dogid"] ?>" 
                                                data-hospitaldogdonorname="<?= $data["hospital_dogdonorname"] ?>" 
                                                data-hospital_donorname="<?= $data["hospital_donorname"] ?>" 
                                                data-breedsid="<?= $data["breeds_id"] ?>" 
                                                data-breedsname="<?= $data["breeds_name"] ?>"
                                                data-bloodtypeid="<?= $data["bloodtype_id"] ?>" 
                                                data-bloodtypename="<?= $data["bloodtype_name"] ?>" >
                                                <i class="material-icons">delete</i> 
                                        </button>
                                        
                                        <button class="btn blue smbtn editbtn" style="margin-top:-5px; padding-left:10px; padding-right:10px; " 
                                                data-hospitaldogid="<?= $data["hospital_dogid"] ?>" 
                                                data-hospitaldogdonorname="<?= $data["hospital_dogdonorname"] ?>" 
                                                data-hospital_donorname="<?= $data["hospital_donorname"] ?>" 
                                                data-breedsid="<?= $data["breeds_id"] ?>" 
                                                data-breedsname="<?= $data["breeds_name"] ?>"
                                                data-bloodtypeid="<?= $data["bloodtype_id"] ?>" 
                                                data-bloodtypename="<?= $data["bloodtype_name"] ?>" >
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
                    <h4>Are you sure to delete ?</h4><br>
                    
                     <h5>Dog</h5><hr>
                    <p style="font-size: 110%; margin-left: 10%">
                        Dog ID : <span id="delshowdogid"></span><br>
                        Dog name : <span id="delshowdogname"></span><br>
                        Owner's name : <span id="delshowdownername"></span><br>
                        Breeds : <span id="delshowbreeds"></span><br>
                        Blood Type : <span id="delshowbloodtype"></span><br>

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
                    <h4>Edit Dog Information <span id="editshowusername"></span></h4>
                    <form class="col s12" action="staff_managedog_edit.php" method="post">
                        <input type="hidden" id="olddogid" name="olddogid">
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix"><img src="../assets/img/dogicon.png" style="width:30px;"></i>
                                <input id="editdogid" name="dogid" type="text" class="validate"  required>
                                <label for="dogid">Dog ID</label>

                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix"><img src="../assets/img/dogicon.png" style="width:30px;"></i>
                                <input id="editdogname" name="dogname" type="text" class="validate"  required>
                                <label for="dogname">Dog Name</label>

                            </div>
                            <div class="input-field col s6">
                                <i class="material-icons prefix"><img src="../assets/img/manicon.png" style="width:30px;"></i>
                                <input id="editdownername" name="downername" type="text" class="validate"  required>
                                <label for="downername">Dog Owner Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s8">                             
                                <i class="material-icons prefix"><img src="../assets/img/dogicon.png" style="width:30px;"></i>
                                <input type="hidden" name="breeds_id" id="breeds_id">
                                <input id="breeds" name="breeds_name" type="text" required readonly>
                                <label for="breeds">Dog Bleeds</label>
                            </div>
                            <div class="col s3">
                                <button type="button" class="btn" style="margin-top:20px;" id="breedssearchbtn">Search</button>
                            </div>
                        </div>
                        <div class="row">
                            <table>
                                <tr>
                                    <td valign="top" style="width:30px;">
                                        <img src="../assets/img/bloodicon.png" style="width:30px; margin-left:10px;">
                                    </td>
                                    <td>
                                        <div class="input-field col s12" >
                                            <select id="editblood" name ="blood" required>
                                                <option value="" disabled selected>Select BloodType</option>
                                                <?php
                                                include "../dbcon.inc.php";
                                                $res = $con->query("SELECT * FROM blood_type");
                                                while ($data = $res->fetch_assoc()) {
                                                    ?>
                                                    <option value="<?= $data["bloodtype_id"] ?>"><?= $data["bloodtype_name"] ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Select BloodType</label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="row ">
                            <button type="submit" class="btn orange right">Save</button>
                            <a href="#!" class="modal-action modal-close waves-effect waves-red btn blue ">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Breeds Search Modal -->
    <div id="breedsmodal" class="modal" style='height:150%;'>
        <div class="modal-content" style="position: static;">
            <div class="row" id="breedssearcharea">
                <div class="input-field col s8">
                    <i class="material-icons prefix">search</i>
                    <input id="breedssearchinput" type="text" class="validate">
                    <label for="breedssearchinput">Search for dog's Bleeds</label>
                </div>
                <div class='col s4' style='padding-top:20px;'>
                    <button type='button' id='breedsmodalsearch' class='btn blue lighten-3 col s5'>Search</button>
                    <button type='button' id='breedsmodalcancel' class='btn amber lighten-3 col s5' style='margin-left:30px;'>Cancel</button>
                </div>
            </div>
            <div id='breedsloader'>
                <br><br>
                <h4 style='margin:0 auto; text-align: center;'>Please wait...</h4>
                <br>
                <div class="progress">
                    <div class="indeterminate"></div>
                </div>
            </div>
            <div class="collection" id='breedsresult'>
                <a href="#!" class="collection-item">Alvin</a>
            </div>
            <div id="breedsadd">
                <br>
                <h6 style="text-align: center;">ไม่พบสายพันธุ์ในระบบ กรุณาเพิ่มสายพันธุ์ใหม่ด้านล่าง</h6>
                <br>
                <div class="row">
                    <div class="input-field col s8 offset-s2" style="text-align: center;">                             
                        <i class="material-icons prefix"><img src="../assets/img/dogicon.png" style="width:30px;"></i>
                        <input id="newbreeds" type="text">
                        <label for="newbreeds">Add New Dog Breeds</label>
                        <button class="btn" id="newbreedsbtn" style="margin:0 auto;">Save New Breeds</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="../assets/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="../assets/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#breedssearchbtn").on("click", function (e) {
                $("#breedsmodal").openModal();
                $("#breedssearchinput").removeAttr("disabled");
                $("#breedsmodalsearch").removeAttr("disabled");
                $("#breedssearchinput").val("");
                $("#breedssearchinput").addClass("active");
                $("#breedssearchinput").focus();
                $("#breedsresult").hide();
                $("#breedsloader").hide();
                $("#breedsadd").hide();
            });

            $("#breedsmodalcancel").on("click", function (e) {
                $("#breedsmodal").closeModal();
            });

            $("#breedsmodalsearch").on("click", function (e) {
                $("#breedssearchinput").attr("disabled", "disabled");
                $("#breedsmodalsearch").attr("disabled", "disabled");
                $("#breedssearchinput").attr("disabled", "disabled");
                $("#breedsresult").hide();
                $("#breedsadd").hide();
                $("#breedsloader").fadeIn(200);
                $.ajax({
                    url: "../api/breedsSearch.php",
                    type: "POST",
                    data: {"searchtext": $("#breedssearchinput").val()},
                    dataType: "json",
                    success: function (data) {
                        if (data.length > 0) {
                            $("#breedsresult").html("");
                            $.each(data, function (i, item) {
                                $("#breedsresult").append('<a href="#!" data-breeds_id="' + item.breeds_id +
                                        '" data-breeds_name="' + item.breeds_name + '" class="collection-item breedselect">' + item.breeds_name + '</a>');
                            });
                            $("#breedsresult").fadeIn(200);
                        } else {
                            $("#breedsadd").fadeIn(200);
                            $("#newbreeds").val($("#breedssearchinput").val());
                            $("#newbreeds").prev().addClass("active");
                            $("#newbreeds").next().addClass("active");
                            $("#newbreeds").addClass("active");
                            $("#newbreeds").addClass("vaild");
                            $("#newbreeds").focus();
                        }
                        $("#breedsloader").hide();
                        $("#breedssearchinput").removeAttr("disabled");
                        $("#breedsmodalsearch").removeAttr("disabled");
                    }
                });
            });

            $("#breedssearchinput").on("keyup", function (e) {
                if (e.keyCode == 13) {
                    $("#breedsmodalsearch").click();
                }
            });

            $("#breedsresult").on("click", ".breedselect", function (e) {
                var breeds_id = $(this).attr("data-breeds_id");
                var breeds_name = $(this).attr("data-breeds_name");
                $("#breeds_id").val(breeds_id);
                $("#breeds").val(breeds_name);
                $("#breeds").prev().addClass("active");
                $("#breeds").next().addClass("active");
                $("#breeds").addClass("active");
                $("#breeds").addClass("vaild");
                $("#breeds").focus();
                $("#breedsmodal").closeModal();
            });

            $("#newbreedsbtn").on("click", function (e) {
                if ($("#newbreeds").val() != "") {
                    $("#breedssearcharea").slideUp(200);
                    $("#breedsloader").fadeIn(200);
                    $("#breedsadd").hide();
                    $.ajax({
                        url: "../api/breedsSearch.php",
                        type: "POST",
                        data: {"newbreeds": $("#newbreeds").val()},
                        dataType: "json",
                        success: function (data) {
                            $("#breeds_id").val(data.breeds_id);
                            $("#breeds").val(data.breeds_name);
                            $("#breeds").prev().addClass("active");
                            $("#breeds").next().addClass("active");
                            $("#breeds").addClass("active");
                            $("#breeds").addClass("vaild");
                            $("#breeds").focus();
                            $("#breedsmodal").closeModal();
                        }
                    });
                }
            });


            $("#navhospital").addClass("active");
            $("#navhospital_managedog").addClass("active");
            $('.collapsible').collapsible();
            $("#datatables").DataTable();

            $(".editbtn").on("click", function (e) {
                $("#olddogid").val($(this).attr("data-hospitaldogid"));
                $("#editdogid").val($(this).attr("data-hospitaldogid"));
                $("#editdogid").prev().addClass("active");
                $("#editdogid").next().addClass("active");
                $("#editdogid").addClass("active");
                $("#editdogid").addClass("vaild");
                $("#editdogid").focus();
                $("#editdogid").focus();

                $("#editdogname").val($(this).attr("data-hospitaldogdonorname"));
                $("#editdogname").prev().addClass("active");
                $("#editdogname").next().addClass("active");
                $("#editdogname").addClass("active");
                $("#editdogname").addClass("vaild");
                $("#editdogname").focus();
                $("#editdogname").focus();

                $("#editdownername").val($(this).attr("data-hospital_donorname"));
                $("#editdownername").prev().addClass("active");
                $("#editdownername").next().addClass("active");
                $("#editdownername").addClass("active");
                $("#editdownername").addClass("vaild");
                $("#editdownername").focus();
                $("#editdownername").focus();

                $("#breeds_id").val($(this).attr("data-breedsid"));
                $("#breeds").val($(this).attr("data-breedsname"));
                $("#breeds").prev().addClass("active");
                $("#breeds").next().addClass("active");
                $("#breeds").addClass("active");
                $("#breeds").addClass("vaild");

                $("#editblood").val($(this).attr("data-bloodtypeid"));
                $("select").material_select();
                $("#editblood").parent().prev(".caret").remove();
                $("#editblood").prev().addClass("active");
                $("#editblood").next().addClass("active");
                $("#editblood").addClass("active");
                $("#editblood").addClass("vaild");

                $('#editmodal').openModal();
            });

            $(".delbtn").on("click", function (e) {
                $("#delshowdogid").html($(this).attr("data-hospitaldogid"));
                $("#delshowdogname").html($(this).attr("data-hospitaldogdonorname"));
                $("#delshowdownername").html($(this).attr("data-hospital_donorname"));
                $("#delshowbreeds").html($(this).attr("data-breedsname"));
                $("#delshowbloodtype").html($(this).attr("data-bloodtypename"));
                $("#delyes").attr("href", "staff_managedog_delete.php?userid=" + $(this).attr("data-hospitaldogid"));
                $('#deletemodal').openModal();
            });
        });
    </script>
</body>
</html>
