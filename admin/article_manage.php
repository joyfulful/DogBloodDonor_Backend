<?php include "session.inc.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="../assets/datatables/media/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="../assets/css/admin.css" />
        <title>Manage Article</title>
    </head>
    <body>
        <?php include "navbar.inc.php"; ?>
        <main>
            <div class="section" id="index-banner">
                <div class="container">
                    Manage Article
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <ul class="tabs">
                            <?php
                            include "../dbcon.inc.php";
                            $res = $con->query("SELECT * FROM article_group");
                            while ($data = $res->fetch_assoc()) {
                                ?>
                                <li class="tab col s3"><a href="#group<?= $data["group_id"] ?>"><?= $data["group_name"] ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php
                    $res = $con->query("SELECT * FROM article_group");
                    while ($data3 = $res->fetch_assoc()) {
                        $group_id = $data3["group_id"];
                        $res2 = $con->query("SELECT * FROM article_data ad "
                                . "LEFT JOIN admin a ON a.admin_id = ad.add_by_admin_id "
                                . "WHERE ad.group_id = '$group_id'"
                                . " ORDER BY ad.article_date DESC");
                        echo $con->error;
                        ?>
                        <div id="group<?= $group_id ?>" class="col s12">
                            <div class="row">
                                <br>
                                <table class="striped" id="datatables<?= $group_id ?>">
                                    <thead>
                                        <tr>
                                            <th>Article ID</th>
                                            <th>Name</th>
                                            <th>Posted Date</th>
                                            <th>Views</th>
                                            <th>Posted By</th>
                                            <th>Last Updated</th>
                                            <th style="width:100px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($data = $res2->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?= $data["article_id"] ?></td>
                                                <td><?= $data["article_name"] ?></td>
                                                <td><?= $data["article_date"] ?></td>
                                                <td><?= $data["article_viewcount"] ?></td>
                                                <td><?= $data["admin_username"] ?></td>
                                                <td><?= ($data["last_updated"] == "0000-00-00 00:00:00" ? "-" : $data["last_updated"]) ?></td>

                                                <td>
                                                    <button class="btn red smbtn delbtn" 
                                                            data-id="<?= $data["article_id"] ?>" data-name="<?= $data["article_name"] ?>" > 
                                                        <i class="material-icons">delete</i>
                                                    </button>
                                                    <a href="article_manage_edit.php?id=<?= $data["article_id"] ?>">
                                                        <button class="btn blue smbtn editbtn"> 
                                                            <img src="../assets/img/pencilflat.png" style="height:17px; margin-bottom:3px;">
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>

                    <?php } ?>
                </div>

            </div>
            <div id="deletemodal" class="modal">
                <div class="modal-content">
                    <div class="card-panel" style="background-color: #990000;color: white">
                        <h4>Are you sure to delete?</h4><br>

                        <h5>Article</h5><hr>
                        <p style="font-size: 110%; margin-left: 10%">
                            Article ID : <span id="delshowid"></span><br>
                            Article Name : <span id="delshowname"></span><br>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" id="delyes" class="waves-effect waves-green btn-flat">Yes</a>
                        <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">No</a>
                    </div>
                </div>
            </div>
        </main>

        <script type="text/javascript" src="../assets/js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="../assets/datatables/media/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
        <script>
            $(document).ready(function () {
                $("#navarticle").addClass("active");
                $("#navarticle_manage").addClass("active");
                $('.collapsible').collapsible();
                $("#datatables1").DataTable();
                $("#datatables2").DataTable();
                $("#datatables3").DataTable();
                $("#datatables4").DataTable();
                $(".delbtn").on("click", function (e) {
                    $("#delshowid").html($(this).attr("data-id"));
                    $("#delshowname").html($(this).attr("data-name"));
                    $("#delyes").attr("href", "article_manage_delete.php?id=" + $(this).attr("data-id"));
                    $('#deletemodal').openModal();
                });

            });
        </script>
    </body>
</html>
