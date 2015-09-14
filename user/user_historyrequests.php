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
                                <th>Donator</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../dbcon.inc.php";
                            $res = $con->query("SELECT * FROM request WHERE from_user_id = '" . $_SESSION["userdata"]["user_id"] . "' "
                                    . "AND request_id IN (SELECT request_id FROM donate WHERE donate_status = 1 OR donate_status = 2)");
                            while ($data = $res->fetch_assoc()) {
                                $request_id = $data["request_id"];
                                $from_user_id = $data["from_user_id"];
                                $for_dog = getDogById($data["for_dog_id"], $con);
                                $getuser = getUserById($data["from_user_id"], $con);

                                $donatorlist = "";
                                //get donator list
                                $donator = $con->query("SELECT * FROM donate WHERE request_id = '$request_id'");
                                $i = 1;
                                while ($donatordata = $donator->fetch_assoc()) {
                                    $dog = getDogById($donatordata["dog_id"], $con);
                                    $user = getUserById($dog["user_id"], $con);
                                    if ($donatorlist == "") {
                                        $donatorlist .= $i++ . ". " . $dog["dog_name"];
                                    } else {
                                        $donatorlist .= "<br>" . $i++ . ". " . $dog["dog_name"];
                                    }
                                }
                                ?>
                                <tr class="showrequest"> 
                                    <td><?= $data["created_time"] ?></td>
                                    <td><?= $for_dog["dog_name"] ?></td>
                                    <td><?= getBloodTypeNameById($for_dog["dog_bloodtype_id"], $con) ?></td>
                                    <td><?= $data["amount_volume"] ?> cc.</td>
                                    <td><?= $data["symptoms"] ?> </td>
                                    <td>
                                        <?= $donatorlist ?>
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
            $("#navhistory_request").addClass("active");
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