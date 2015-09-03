<?php include "session.inc.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="../assets/css/admin.css" />
        <link rel="stylesheet" href="../assets/css/animate.css" />
        <title>About Us</title>
    </head>
    <body>
        <?php include "../hospital/navbar.inc.php"; ?>
        <main>
            <div class="section" id="index-banner">
                <div class="container">
                    About Us
                </div>
            </div>
            <div class="container" style="margin-top: 5%; margin-left: 20%">
                 <div class="row">
                     
                     <div class="col s12">
                         
                         
                             <h4>Developer Team:</h4>
                             <p style="font-size: 120%;margin-left: 10%">น.ส.เพ็ญรดี คลังสุนทรรังษี<br>
                                        น.ส.ภัทราภรณ์ ด้วงสำรวย<br>
                                        น.ส.วริศรา เอกศิริ<br><br>
                                        คณะเทคโนโลยีสารสนเทศ มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าธนบุรี</p>
                                        <br>
                                        <h4>Email: </h4>
                                         <p style="font-size: 120%;margin-left: 10%">Varisara.Eaksiri@gmail.com</p>
                         </div>
                    </div>
                </div>

                </div>
            <div id="notificationmodal" class="modal modal-fixed-footer">
                <div class="modal-content" style="position: static;">
                    <br><br><br>
                    <h4 style="margin:0 auto; text-align: center;">Loading...<br><br><br><br>
                        <div class="preloader-wrapper big active">
                            <div class="spinner-layer spinner-blue-only">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div><div class="gap-patch">
                                    <div class="circle"></div>
                                </div><div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>
                    </h4>
                </div>
                <div class="modal-footer">
                    <div class="row" style="margin-top:10px; height:20px;">
                        <div class="col s10">
                            <div id="check" style="margin-top:5px;">
                                <input type="checkbox" class="filled-in" id="filled-in-box"  required="" />
                                <label for="filled-in-box">Do not show notification for these blood(s) again.</label>
                            </div>
                            <div id="btnloader" style="display: none; height:20px; overflow: no-content;">
                                <div class="preloader-wrapper small active">
                                    <div class="spinner-layer spinner-blue-only">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div><div class="gap-patch">
                                            <div class="circle"></div>
                                        </div><div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>
                                </div>
                                &nbsp;&nbsp;Saving notification state, Please wait...
                            </div>
                        </div>

                        <div class="col s2">
                            <button class="btn waves-effect waves-green" id="notibtn" style="margin-top:5px;"><span id="btntext">Close</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </main>


        <script type="text/javascript" src="../assets/js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
        <script>
            var isCheck = false;
            $(document).ready(function () {
                $('.collapsible').collapsible();
                $("#navabout").addClass("active");
            });
        </script>
    </body>
</html>


