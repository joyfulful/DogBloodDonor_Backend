<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title></title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/css/animate.css" />
        <link rel="stylesheet" href="assets/css/doogblooddonor.css" />
        <style>
            body,html{
                background-color:#eeeee ;
            }
            .modal-content{
                width:600px;
                height:380px;
                position:absolute;
                left:50%;
                top:50%;
                margin:-180px 0 0 -300px;
                z-index:2;
            }
            .dog{
                width:192px;
                height:203px;
                position:absolute;
                left:50%;
                top:50%;
                margin:-185px 0 0 -471px;
                z-index:3;
                transform: rotate(-7deg);
            }
            .modal-body{
                padding-top:20px;
                border:none;
            }
            .form{
                width:470px;
                margin:0 auto;
            }
            #loginfb{
                margin-top:14px;
            }
            .blood{
                position: fixed;
                bottom:10px;
                right:10px;
                width:400px;
            }
            .blood img{
                width:60px;
            }
            .blood table{
                width:100%;
            }
            .footer { 
                display: block;
            }
        </style>
    </head>
    <body>
        <div class="dog">
            <img src="assets/img/dog_left.png">
        </div>
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="text-center">Please Sign in</h1>
            </div>
            <div class="modal-body">
                <div class="form">
                    <div class="form-group">
                        <input id="username" type="text" class="form-control input-lg" placeholder="Username" required autofocus>
                    </div>
                    <div class="form-group">
                        <input id="password" type="password" class="form-control input-lg" placeholder="Password" required="" >
                    </div>
                    <div class="form-group">
                        <button id="loginmail" class="btn btn-primary btn-lg btn-block ">Sign In</button>
                        <button id="loginfb" class="btn btn-primary btn-lg btn-block">Login with Facebook</button>
                    </div>
                    <div id="errortext">
                    </div>
                </div>
            </div>


            <script type="text/javascript" src="assets/js/jquery-2.1.4.min.js"></script>
            <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
            <script>
                window.fbAsyncInit = function () {
                    FB.init({
                        appId: '835322439838787',
                        xfbml: true,
                        version: 'v2.4'
                    });
                };

                (function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) {
                        return;
                    }
                    js = d.createElement(s);
                    js.id = id;
                    js.src = "//connect.facebook.net/en_US/sdk.js";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));

                $(document).ready(function (e) {
                    $("#username").focus();
                    $("#password").on("keyup", function (e) {
                        if (e.keyCode == 13) {
                            $("#loginmail").click();
                        }
                    });
                    $("#username").on("keyup", function (e) {
                        if (e.keyCode == 13) {
                            $("#password").focus();
                        }
                    });
                    $("#loginmail").on("click", function (e) {
                        $("#errortext").fadeOut(100);
                        $(".modal-content").animate({"height": "380px"}, 100);
                        $("#loginmail").attr("disabled", "disabled");
                        $("#loginmail").html("Logging in...");
                        var username = $("#username").val();
                        var password = $("#password").val();
                        $.ajax({
                            type: 'POST',
                            data: {"username": username, "password": password, "type": "mail"},
                            url: 'api/authentication.php',
                            dataType: 'json',
                            success: function (data) {
                                if (data.result == "1") {
                                    $("#errortext").html("");
                                    document.location = data.role;
                                }
                                else {
                                    $(".modal-content").animate({"height": "400px"}, 100);
                                    setTimeout(function () {
                                        $("#errortext").html("Username or Password Wrong !<br><br>");
                                        $("#errortext").fadeIn(100);
                                        $("#loginmail").removeAttr("disabled");
                                        $("#loginmail").html("Sign In");
                                    }, 100);
                                }
                            }
                        });
                    });

                    $("#loginfb").on("click", function (e) {
                        $("#errortext").fadeOut(100);
                        $(".modal-content").animate({"height": "380px"}, 100);
                        $("#loginfb").attr("disabled", "disabled");
                        $("#loginfb").html("Connecting Facebook...");
                        FB.login(function (response) {
                            if (response.status === 'connected') {
                                token = response.authResponse.accessToken;
                                FB.api('/me', function (response) {
                                    var fbid = response.id;
                                    var name = response.name;
                                    alert(fbid);
                                    $.ajax({
                                        type: 'POST',
                                        data: {"fbid": fbid, "name": name, "type": "fb"},
                                        url: 'api/authentication.php',
                                        dataType: 'json',
                                        success: function (data) {
                                            if (data.result == "1") {
                                                $("#errortext").html("");
                                                document.location = "user";
                                            }
                                            else {
                                                $(".modal-content").animate({"height": "400px"}, 100);
                                                setTimeout(function () {
                                                    $("#errortext").html("User are Not Regsitered !<br><br>");
                                                    $("#errortext").fadeIn(100);
                                                    $("#loginfb").removeAttr("disabled");
                                                    $("#loginfb").html("Login with Facebook");
                                                }, 100);
                                            }
                                        }
                                    });
                                });
                            }
                        });
                    });

                });
            </script>
    </body>
</html>
