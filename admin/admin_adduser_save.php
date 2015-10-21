<?php
include "session.inc.php";
include "../dbcon.inc.php";
$username = $con->real_escape_string($_POST["username"]);
$password = md5($con->real_escape_string($_POST["password"]));
$checkExists = $con->query("SELECT * FROM admin WHERE admin_username = '$username'");
if ($checkExists->num_rows > 0) {
    echo "<script>alert('Username already exists.');window.history.back();</script>";
} else {
    $queryUser = $con->query("INSERT INTO `admin`(`admin_id`, `admin_username`, `admin_password`) VALUES (null,'$username','$password' )");
    ?>
<script>
    document.location = "admin_manageuser.php";
</script>
<?php
}
?>