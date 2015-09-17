<?php include "session.inc.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="../assets/css/admin.css" />
        <title>Add New Blood</title>
        <style>
            input[type=text]:disabled, input[type=text][readonly="readonly"], input[type=password]:disabled, 
            input[type=password][readonly="readonly"], input[type=email]:disabled, input[type=email][readonly="readonly"],
            input[type=url]:disabled, input[type=url][readonly="readonly"], input[type=time]:disabled, 
            input[type=time][readonly="readonly"], input[type=date]:disabled, input[type=date][readonly="readonly"], 
            input[type=datetime-local]:disabled, input[type=datetime-local][readonly="readonly"], input[type=tel]:disabled,
            input[type=tel][readonly="readonly"], input[type=number]:disabled, input[type=number][readonly="readonly"], 
            input[type=search]:disabled, input[type=search][readonly="readonly"], textarea.materialize-textarea:disabled,
            textarea.materialize-textarea[readonly="readonly"] {
                color:black !important;
                border-bottom-color: black !important;
            }
        </style>
    </head>
    <body>

        <?php include "navbar.inc.php"; ?>
        <main>
            <div class="section" id="index-banner">
                <div class="container">
                    <h3>Add New Blood</h3>
                </div>
            </div>

            <div class="container">
                <form class="col s12" id="form" action="staff_addblood_save.php" method="post">
                    <div class="row">
                        <br><br>
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix"><img src="../assets/img/id18.png" style="width:30px;"></i>
                                <input id="dogid" name="dogid" type="text" class="validate" required readonly>
                                <label for="dogid">Dog ID</label>
                            </div>
                            <div class='input-field col s3' id='newdogbtn'>
                                <button type='button' id="dogaddbtn" class='btn grey darken-3 col s10'>
                                    <i class="material-icons left">add</i>
                                    New Dog
                                </button>
                            </div>
                            <div class='input-field col s3' style='display:none' id='newdogcheck'>
                                <button type='button' id="newdogcheckbtn" class='btn orange col s10'>
                                    <i class="material-icons left">add</i>
                                    Check Dog ID
                                </button>
                            </div>
                            <div class='input-field col s3' style='display:none' id='newdogcheckcancel'>
                                <a href="staff_addblood.php">
                                    <button type='button' id="newdogcancel" class='btn orange darken-3 col s10'>
                                        <i class="material-icons left">cancel</i>
                                        Cancel
                                    </button>
                                </a>
                            </div>
                            <div class='input-field col s3'>
                                <button type='button' id="dogsearchbtn" class='btn grey darken-3 col s10'>
                                    <i class="material-icons left">search</i>
                                    Search Dog
                                </button>
                            </div>
                        </div>
                        <div class="row" id="dogdetails">
                            <div class="input-field col s6">
                                <i class="material-icons prefix"><img src="../assets/img/dogicon.png" style="width:30px;"></i>

                                <input id="dogname" name="dogname" type="text" class="validate" required disabled>
                                <label for="dogname">Dog Name</label>
                            </div>
                            <div class="input-field col s6">                             
                                <i class="material-icons prefix"><img src="../assets/img/manicon.png" style="width:30px;"></i>
                                <input id="ownername" name="ownername" type="text" class="validate" required disabled>
                                <label for="ownername">Owner Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">                             
                                <i class="material-icons prefix"><img src="../assets/img/dog98.png" style="width:30px;"></i>
                                <input type="hidden" name="breeds_id" id="breeds_id">
                                <input id="breeds" name="breeds_name" type="text" required readonly disabled>
                                <label for="breeds">Breeds</label>
                            </div>
                            <div class="col s3">
                                <button type="button" class="btn" disabled style="margin-top:20px;" id="breedssearchbtn">Search</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <table>
                                    <tr>
                                        <td valign="top" style="width:30px;">
                                            <img src="../assets/img/bloodicon.png" style="width:30px;">
                                        </td>
                                        <td>
                                            <div class="input-field col s12" >
                                                <select id="blood" name ="blood" required disabled>
                                                    <option value="" disabled selected>Select BloodType</option>
                                                    <?php
                                                    include "../dbcon.inc.php";
                                                    $res = $con->query("SELECT * FROM blood_type where bloodtype_id != 9");
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
                        </div>
                        <div class="row">
                            <div class="input-field col s5">
                                <i class="material-icons prefix">
                                    <img src="../assets/img/volumeicon .png" style="width:30px" >
                                </i>
                                <input id="volume" name="volume" type="number" min="0" class="validate" required disabled>
                                <label for ="volume">Volume</label>
                            </div>
                            <div class="col s1" > 
                                <div style="margin-top: 40px">CC.</div>
                            </div>

                            <div class="input-field col s5 ">
                                <input id="pcv" name="pcv" type="number" step="0.01" value="0.00" min="0" max="100.00" class="validate" required disabled>
                                <label for="pcv">PCV </label> 
                            </div>
                            <div class="col s1" > 
                                <div style="margin-top: 40px"> % </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6 ">
                                <i class="material-icons prefix"><img src="../assets/img/calendar146.png" style="width:30px" ></i>
                                <input type="text"  name = "date" id = "date" readonly value="<?php echo date('d-m-Y'); ?>"  >
                                <label for="date"> </label>
                            </div>
                        </div>
                        <button type="submit" style='margin-top:3px;' id="savebtn" disabled class="btn orange right">Save</button>
                    </div>

                </form>
            </div>
        </main>
        <!-- Dog Search Modal -->
        <div id="dogsearchmodal" class="modal" style='height:150%;'>
            <div class="modal-content" style="position: static;">
                <div class="row" id="dogsearchsearcharea">
                    <div class='col s2' style='margin-top:12px; text-align: right;'>
                        Search By : 
                    </div>
                    <div class='col s10'>
                        <select id="searchby">
                            <option value="dogid">Dog ID</option>
                            <option value="dogname">Dog's Name</option>
                            <option value="ownername">Owner's Name</option>
                        </select>
                    </div>
                    <div class="input-field col s8">
                        <i class="material-icons prefix">search</i>
                        <input id="dogsearchinput" type="text" class="validate">
                    </div>
                    <div class='col s4' style='padding-top:20px;'>
                        <button type='button' id='dogsearchmodalsearch' class='btn blue lighten-3 col s5'>Search</button>
                        <button type='button' id='dogsearchmodalcancel' class='btn amber lighten-3 col s5' style='margin-left:30px;'>Cancel</button>
                    </div>
                </div>
                <div id='dogsearchloader'>
                    <br><br>
                    <h4 style='margin:0 auto; text-align: center;'>Please wait...</h4>
                    <br>
                    <div class="progress">
                        <div class="indeterminate"></div>
                    </div>
                </div>
                <div class="collection" id='dogsearchresult'>
                    <a href="#!" class="collection-item">Alvin</a>
                </div>
                <div id="dogsearchadd">
                    <br>
                    <h6 style="text-align: center;">Dog Not Found with provided search criteria.</h6>
                    <br>
                </div>
            </div>
        </div>

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
        <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
        <script type="text/javascript" src="../assets/js/staff_addblood.js"></script>

    </body>
</html>
