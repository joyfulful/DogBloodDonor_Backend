<?php

include "../dbcon.inc.php";
$hos = $con->real_escape_string($_POST["hos"]);
$queryUser = $con->query(" SELECT hu.hospital_user FROM `hospital_user` hu
JOIN hospital h ON hu.hospital_id = h.hospital_id
WHERE h.hospital_shortcode = '$hos'
ORDER BY hu.hospital_user DESC
LIMIT 0,1");
$userdata = $queryUser->fetch_assoc();
echo $hos."_".sprintf('%02d',(str_replace($hos."_","",$userdata["hospital_user"])+1));


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

