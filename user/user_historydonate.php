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
                                <th>Volume (CC.)</th>
                                <th>Requester Name</th>

                            </tr>                                        
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../dbcon.inc.php";
                            $currentdate = date('Y-m-d', time());
                            $res = $con->query("SELECT * FROM donate WHERE dog_id IN "
                                    . "(SELECT dog_id FROM user_dog WHERE user_id = '" . $_SESSION["userdata"]["user_id"] . "') "
                                    . " AND donate_status IN (1)");
                            while ($data = $res->fetch_assoc()) {
                                $request = getRequestById($data["request_id"], $con);        
                                $donator_dog = getDogById($data["dog_id"], $con);
                                $requester_dog = getDogById($request["for_dog_id"], $con);
                                $requester_owner = getUserById($requester_dog["user_id"], $con);
                              
                                ?>
                             
                                <tr class="showdonate">
                                    <td><?= $data["donate_lastupdate"] ?></td>
                                    <td><?= $donator_dog["dog_name"] ?></td>
                                    <td><?= getBloodTypeNameById($donator_dog["dog_bloodtype_id"], $con) ?></td>
                                    <td><?= $requester_dog["dog_name"] ?> </td>
                                    <td><?= $request["amount_volume"] ?></td>
                                    <td><?= $requester_owner["firstname"] . " " . $requester_owner["lastname"] ?></td>
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

<?php

function getRequestById($request_id, $con) {
    $res = $con->query("SELECT * FROM request WHERE request_id = '$request_id'");
    if ($res->num_rows > 0) {
        return $res->fetch_assoc();
    } else {
        return array();
    }
}

function getDogById($dog_id, $con) {
    $res = $con->query("SELECT * FROM user_dog WHERE dog_id = '$dog_id'");
    if ($res->num_rows > 0) {
        return $res->fetch_assoc();
    } else {
        return array();
    }
}

function getUserById($user_id, $con) {
    $res = $con->query("SELECT * FROM user_profile WHERE user_id = '$user_id'");
    if ($res->num_rows > 0) {
        return $res->fetch_assoc();
    } else {
        return array();
    }
}

function getBloodTypeNameById($bloodtype_id, $con) {
    $res = $con->query("SELECT * FROM blood_type WHERE bloodtype_id = '$bloodtype_id'");
    if ($res->num_rows > 0) {
        $data = $res->fetch_assoc();
        return $data["bloodtype_name"];
    } else {
        return array();
    }
}
?>