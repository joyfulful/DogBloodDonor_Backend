<?php include "session.inc.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="../assets/datatables/media/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="../assets/css/admin.css" />
        <title>History of Used Blood</title>
    </head>
    <body>

        <?php include "navbar.inc.php"; ?>
        <main>

            <div class="section" id="index-banner">
                <div class="container">
                    History of Used Blood
                </div>
            </div>
            <div class="container">
                <div class="row" >
                    <br>
                    <table class="striped" id="datatables">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Used By</th>
                                <th style="width: 15%">Breed</th>
                                <th>Blood Type</th>
                                <th>Dog Name</th>
                                <th>Owner Name</th>
                                <th>Volume</th>
                                <th>PCV</th>
                                <th>Remarks</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../dbcon.inc.php";
                            $res = $con->query("SELECT * FROM hospital_bloodstore hb "
                                    . "JOIN hospital_user hu on hu.hospital_userid = hb.hospitaluser_id "
                                    . "JOIN hospital_bloodtransaction hbt on hbt.bloodstore_id = hb.bloodstore_id "
                                    . "JOIN hospital_dog hd on hd.hospital_dogid = hb.hospital_dogid "                                                
                                    . "JOIN blood_type bt on hd.bloodtype_id = bt.bloodtype_id "         
                                    . "JOIN dog_breeds db on db.breeds_id = hd.breeds_id where "
                                    . "hu.hospital_user LIKE '" . substr($_SESSION["userdata"]["hospital_user"], 0, 2) . "%' "
                                    . "and hb.status = 0");
                            while ($data = $res->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $data["bloodtrasaction_id"] ?></td>
                                    <td><?= $data["hospital_user"] ?></td>      
                                    <td><?= $data["breeds_name"] ?></td>
                                    <td><?= $data["bloodtype_name"] ?></td>
                                    <td><?= $data["hospital_dogdonorname"] ?> </td>
                                    <td><?= $data["hospital_donorname"] ?> </td>
                                    <td> <?= $data["volume"] ?> ml.</td>
                                    <td> <?= $data["pcv"] ?></td>
                                    <td><?= ($data["action"] == "E" ? "Expired" : "Used") ?></td>
                                     <td><?= $data["date_useblood"] ?> 

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <script type="text/javascript" src="../assets/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="../assets/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
    <script>

        $(document).ready(function () {
            $("#navhistory").addClass("active");
            $('.collapsible').collapsible();
            $("#datatables").DataTable({
                "order": [[2, "desc"]]
            });


        });
    </script>
</body>
</html>
