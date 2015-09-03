<?php
include "./session.inc.php";
include "../dbcon.inc.php";
if (isset($_POST["ack"])) {
    //user don't want to see more notification for those bloods
    $res = getNotification($_SESSION["userdata"], $con);
    while ($data = $res->fetch_assoc()) {
        saveNotification($_SESSION["userdata"], $con, $data["bloodstore_id"]);
    }
} else {
    //get notification
    $res = getNotification($_SESSION["userdata"], $con);
    if ($res->num_rows > 0) {
        echo '<ul class="collection with-header animated fadeIn"><li class="collection-header"><h5>Notification</h5></li>';
        while ($data = $res->fetch_assoc()) {
            $now = time(); // or your date as well
            $your_date = strtotime($data["exp_date"]);
            $datediff = $now - $your_date;
            $daydiff = floor($datediff / (60 * 60 * 24));
            $isexpried = false;
            if ($daydiff > 0) {
                $isexpried = true;
            }
            $daydiff = abs($daydiff);
            ?>

            <li class="collection-item avatar">
                <a class="ano" href="staff_manageblood.php?type=<?= $data["bloodtype_id"] ?>">
                    <div class="row" style="padding:0; margin:0;">
                        <div class="col s1">
                            <img src="../assets/img/<?= strtolower(str_replace(" ", '', $data["bloodtype_name"])) ?>.png" style="height:60px;">
                        </div>
                        <div class="col s8">
                            <span class="title">Blood Type : <?= $data["bloodtype_name"] ?> (Blood ID : <?= $data["bloodstore_id"] ?>)</span>
                            <p> Status : In Stock
                                <?php
                                if ($isexpried) {
                                    echo "<span style='color:red'> (Expried !)</span>";
                                }
                                ?>
                                <br>
                                Expired Date : <?= date("j M Y", strtotime($data["exp_date"])) ?>&nbsp;&nbsp;
                                <?php if ($isexpried) { ?>
                                    (Expired for <?= $daydiff ?> Day<?= ($daydiff > 1 ? "s" : "") ?>)
                                <?php } else { ?>
                                    (<?= $daydiff ?> Day<?= ($daydiff > 1 ? "s" : "") ?> Left)
                                <?php } ?>
                                <br>
                            </p>
                        </div>
                        <div class="col s3">
                            <b>Dog Donor: </b><?= $data["hospital_dogdonorname"] ?>
                            <br>
                            <b>Volume: </b><?= $data["volume"] ?> ml.
                            <br>
                            <b>PCV: </b><?= $data["pcv"] ?>
                        </div>
                    </div>
                </a>
            </li>
            <?php
        }
        echo "</ul>";
    }//end if num rows
}

function getNotification($userdata, $con) {
    $hospital_userid = $userdata["hospital_userid"];
    $query = "SELECT * FROM hospital_bloodstore hb "
            . "JOIN hospital_user hu on hu.hospital_userid = hb.hospitaluser_id "
            . "JOIN hospital_dog hd on hd.hospital_dogid = hb.hospital_dogid "
            . "JOIN blood_type bt on hd.bloodtype_id = bt.bloodtype_id "
            . "where hu.hospital_user LIKE '" . substr($userdata["hospital_user"], 0, 2) . "%' "
            . "AND hb.status = 1 AND hb.exp_date < DATE_ADD(now(), INTERVAL 1 MONTH) "
            . "AND hb.bloodstore_id NOT IN "
            . " (SELECT hnl.bloodstore_id FROM hospital_notificationlog hnl WHERE hnl.hospital_userid = '$hospital_userid')"
            . "ORDER BY hb.exp_date ASC;";
    $res = $con->query($query);
    return $res;
}

function saveNotification($userdata, $con, $bloodstore_id) {
    $hospital_userid = $userdata["hospital_userid"];
    $query = "INSERT INTO `hospital_notificationlog`(`noti_id`, `hospital_userid`, `bloodstore_id`, `ack_date`) "
            . "VALUES (null,'$hospital_userid','$bloodstore_id',now())";
    $con->query($query);
}
