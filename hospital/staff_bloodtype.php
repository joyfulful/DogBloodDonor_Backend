<?php include "session.inc.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="../assets/css/admin.css" />
        <title>Blood Group</title>
    </head>
    <body>
        <?php include "navbar.inc.php"; ?>
        <main>
            <div class="section" id="index-banner">
                <div class="container">
                    <h3>Blood Group </h3>
                </div>
            </div>
            <div class = "container">
                <div class ="row" >
                    <table>
                        <tr>

                        </tr>
                    </table>

                </div>
                <br><br>

                <table class="table" > 
                    <tr>

                        <?php
                        include "../dbcon.inc.php";
                        $res = $con->query("SELECT * FROM blood_type where bloodtype_name <> 'ไม่สามารถระบุได้' ");
                        $i = 0;

                        while ($data = $res->fetch_assoc()) {
                            $i++;
                            if ($i % 5 == 0) {
                                echo '</tr><tr>';
                            }
                            ?>
                            <td> 
                                <a href="staff_manageblood.php?type=<?= $data["bloodtype_id"] ?>" id="<?= $data["bloodtype_name"] ?>" 
                                   name="<?= $data["bloodtype_name"] ?>">
                                    <div class="card small hover">
                                        <div class="">

                                            &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <img src="../assets/img/<?= strtolower(str_replace(" ", '', $data["bloodtype_name"])) ?>.png"   style="height:150px" align = "middle">
                                        </div>
                                        <br>
                                        <hr color = "gray" size="1.78">
                                        <div class="card-content" >
                                            <span class="card-title activator grey-text text-darken-4">
                                                <?php
                                                $hospital_id = $_SESSION["userdata"]["hospital_id"];
                                                $findres = $con->query("SELECT SUM(hb.volume) FROM hospital_bloodstore hb "
                                                        . "JOIN hospital_dog hd ON hd.hospital_dogid = hb.hospital_dogid "
                                                        . "JOIN hospital_user hu ON hu.hospital_userid = hb.hospitaluser_id"
                                                        . " WHERE hd.bloodtype_id = '" . $data["bloodtype_id"] . "' "
                                                        . " AND hb.status = 1 AND hu.hospital_id = '$hospital_id'");
                                                $countdata = $findres->fetch_array();
                                                $count = $countdata[0];
                                                if ($count == "") {
                                                    $count = 0;
                                                }
                                                ?>
                                                <p style="line-height: 35px;">
                                                    <b><?= $data["bloodtype_name"] ?></b><br>
                                                    <span style="font-size:0.8em;">Blood Stocks: <?= $count ?> cc.</span>
                                                </p>
                                        </div>
                                    </div>

                                </a>
                            </td>
                        <?php }
                        ?>
                    </tr>


                </table>
            </div>

        </main>

        <script type="text/javascript" src="../assets/js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
        <script>
            $(document).ready(function () {
                $("#navhospital").addClass("active");
                $("#navhospital_manageblood").addClass("active");
                $('.collapsible').collapsible();

            });
        </script>

    </body>
</html>
