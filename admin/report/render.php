<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../assets/font/th-sarabun/fonts.css">
        <title>Welcome</title>
        <style>
            html,body{
                font-family: 'Conv_THSarabunNew';
                margin:0;
                padding:0;
            }
            #top{
                position: relative;
                width:100%;
                height:220px;
                border-style: none;
                border-bottom: thin solid black;
                text-align: center;
            }
            #top img{
                height:80%;
            }
            #username{
                position: absolute;
                bottom:20px;
                left:50px;
                font-size:25px;
                font-family: 'Conv_THSarabunNew';
            }
            #date{
                position: absolute;
                bottom:20px;
                right:50px;
                font-size:25px;
                font-family: 'Conv_THSarabunNew';
            }
        </style>
    </head>
    <body>
        <div id='top'>
            <img src='../../assets/img/logo1.png'>
            <div id="username">Exported By : <?=$_GET["user"]?></div>
            <div id="date">Date : <?=date("j",time())?> <?=date("F",time())?> <?=date("Y",time())?></div>
        </div>
        <br><br>
        <div id="graph">
            <?php include $_GET["reporttype"].".php"; ?>
        </div>
    </body>
</html>
