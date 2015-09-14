<?php include "session.inc.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="../assets/css/admin.css" />
        <title>Report</title>
        <style>

        </style>
    </head>
    <body>

        <?php include "navbar.inc.php"; ?>
        <main>
            <div class="section" id="index-banner">
                <div class="container">
                    <h3>Report</h3>
                </div>
            </div>
            <div class ="container col s12 ">
                <div class="row">
                    <div  class="input-field col s3">

                        <h5> Type Of Report : </h5>
                    </div>

                    <div class="input-field col s3">
                        <a class='dropdown-button btn' href='#' data-activates='dropdown1' style="width: 350px">Select type of Report</a>
                        <ul id='dropdown1' class='dropdown-content'>
                            <li><a href="#!">Breeds Report</a></li>
                            <li><a href="#!">Blood Donation Report</a></li>
                            <li><a href="#!">Blood Requesting Report</a></li>
                        </ul>    
                    </div>
                </div>

                <div class="row">
                    <div  class="input-field col s3">
                        <h5> Type Of File : </h5>
                    </div>
                    <div class="input-field col s3">
                        <a class='dropdown-button btn' href='#' data-activates='dropdown2' style="width: 250px">Select file type of Export</a>
                        <ul id='dropdown2' class='dropdown-content'>
                            <li><a href="#!">PDF</a></li>
                            <li><a href="#!">Excel</a></li>
                            <li><a href="#!">word</a></li>
                        </ul>    
                    </div>
                </div>


            </div>

            <script type="text/javascript" src="../assets/js/jquery-2.1.4.min.js"></script>
            <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
            <script type="text/javascript" src="../assets/js/staff_addblood.js"></script>
            <script>
             $(document).ready(function () {
                $("#navuser").addClass("active");
                $("#navreport").addClass("active");
                $("#datatables").DataTable();
            
            
            </script>

                
    </body>
</html>
