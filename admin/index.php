<?php include "session.inc.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="../assets/css/admin.css" />
        <title>Welcome</title>
    </head>
    <body>
        <?php include "navbar.inc.php"; ?>
        <main>
            <div class="section" id="index-banner">
                <div class="container">
                    Welcome
                </div>
            </div>
            <div class="container" style="text-align: center;margin-top: 60px">
                
                <h2>You are : <?php echo $_SESSION["userdata"]["admin_username"]; ?></h2>
            </div>
        </main>

        <script type="text/javascript" src="../assets/js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.collapsible').collapsible();
                $("#navindex").addClass("active");
            });
        </script>
    </body>
</html>
