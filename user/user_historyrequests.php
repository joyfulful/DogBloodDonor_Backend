<?php include "session.inc.php";
?>
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
                    Blood Donation History
                </div>
            </div>
            <div class="container">
                <p>
                    <input type="checkbox" class="filled-in" id="filled-in-box" checked="checked" />
                    <label for="filled-in-box">Filled in</label>
                </p>
                <p>
                    <input type="checkbox" class="filled-in" id="filled-in-box" checked="checked" />
                    <label for="filled-in-box">Filled in</label>
                </p>
                <div class="row">
                    <br>
                    <table class="striped" id="datatables">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Used By</th>
                                <th>Date to Used</th>
                                <th>Blood Type</th>
                                <th>Dog Donor Name</th>
                                <th>Owner Name</th>
                                <th>Volume</th>
                                <th>PCV</th>                                         
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../dbcon.inc.php";
                            $res = $con->query("SELECT * FROM hospital_bloodstore hb JOIN blood_type bt on hb.bloodtype_id = bt.bloodtype_id  "
                                    . "JOIN hospital_user hu on hu.hospital_userid = hb.hospitaluser_id "
                                    . "JOIN hospital_bloodtransaction hbt on hbt.bloodstore_id = hb.bloodstore_id "
                                    . "where "
                                    . "hu.hospital_user LIKE '" . substr($_SESSION["userdata"]["hospital_user"], 0, 2) . "%' "
                                    . "and hb.status = 0 order by hbt.date_useblood DESC");
                            while ($data = $res->fetch_assoc()) {
                                ?>
                                <tr class="dog1">
                                    <td><?= $data["bloodtrasaction_id"] ?></td>
                                    <td><?= $data["hospital_user"] ?></td>
                                    <td><?= $data["date_useblood"] ?> 
                                    <td><?= $data["bloodtype_name"] ?></td>
                                    <td><?= $data["dogdonor_name"] ?> </td>
                                    <td><?= $data["donor_name"] ?> </td>
                                    <td> <?= $data["volume"] ?></td>
                                    <td> <?= $data["pcv"] ?></td>

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
            $("#navhistory_donate").addClass("active");
            $('.collapsible').collapsible();
            $("#datatables").DataTable();


        });
    </script>
</body>
</html>
