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
                                <th>Request Date</th>
                                <th>For Dog Name</th>
                                <th>Blood Type</th> 
                                <th>Volume</th>
                                <th>Symptoms</th>
                                <th></th>
                                 
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../dbcon.inc.php";
                            $res = $con->query(" SELECT r.created_time, udr.dog_name as request_dog_name ,bt.bloodtype_name,r.amount_volume,r.symptoms,upd.firstname,udd.dog_name as donate_dog_name,d.donate_lastupdate
                                                    FROM request r 
                                                    JOIN donate d ON d.request_id = r.request_id 
                                                    JOIN user_dog udr ON udr.dog_id = r.for_dog_id 
                                                    JOIN user_dog udd ON udd.dog_id = d.dog_id  
                                                    JOIN user_profile up ON up.user_id = r.from_user_id 
                                                    JOIN user_profile upd ON upd.user_id = udd.user_id
                                                    JOIN user u ON u.user_id = r.from_user_id
                                                    JOIN blood_type bt ON bt.bloodtype_id = udr.dog_bloodtype_id WHERE u.user_id LIKE '" . $_SESSION["userdata"]["user_id"] . "' ");
                          while ($data = $res->fetch_assoc()) {
                                ?>
                                <tr class="showrequest"> 
                                    <td><?= $data["created_time"] ?></td>
                                    <td><?= $data["request_dog_name"] ?></td>
                                    <td><?= $data["bloodtype_name"] ?></td>
                                    <td><?= $data["amount_volume"] ?></td>
                                    <td><?= $data["symptoms"] ?> </td>
                                    <td></td>
                                   
                                    
                                    <td></td>
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
            $("#navhistory_request").addClass("active");
            $('.collapsible').collapsible();
            $("#datatables").DataTable();


        });
    </script>
</body>
</html>
