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
                <div class="row">
                    <br>
                    <table class="striped" id="datatables">
                        <thead>
                            <tr>
                                <th>Donate Date</th>
                                <th>Dog Donor Name</th>
                                <th>Blood Type</th>
                                <th>For Dog Name</th>
                                <th>Requester Name</th> 
                                <th>Remark</th>

                            </tr>                                        
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../dbcon.inc.php";
                            $res = $con->query("SELECT  d.donate_lastupdate ,ud.dog_name as dornor_dogname ,bt.bloodtype_name, ur.firstname as requester_name ,udr.dog_name as requester_dogname
                                                FROM donate d 
                                                JOIN user_dog ud  ON ud.dog_id = d.dog_id
                                                JOIN user u ON u.user_id = ud.user_id 
                                                JOIN blood_type bt ON bt.bloodtype_id =ud.dog_bloodtype_id
                                                JOIN request r ON r.request_id = d.request_id
                                                JOIN user_profile ur ON ur.user_id = r.from_user_id
                                                JOIN user_dog udr ON udr.dog_id = r.for_dog_id
                                                WHERE u.user_id LIKE '" . $_SESSION["userdata"]["user_id"] . "' ");
                            while ($data = $res->fetch_assoc()) {
                                ?>
                                <tr class="showdonate">
                                    <td><?= $data["donate_lastupdate"] ?></td>
                                    <td><?= $data["dornor_dogname"] ?></td>
                                    <td><?= $data["bloodtype_name"] ?></td>
                                    <td><?= $data["requester_dogname"] ?> </td>
                                    <td><?= $data["requester_name"] ?></td>
                                    <td>
                                        
                                    </td>


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
