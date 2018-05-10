<?php
session_start();
include 'scripts/connect.php';
$id = $_SESSION['id'];
mysqli_query($con, "UPDATE `users` SET `activated` = '0' WHERE `id`='$id'");
$_SESSION = array();
session_destroy();
if (!isset($_SESSION['email'])) {
    header("location: index.php");
} else {
    echo "<h1>Could not log you out, Sorry!</h1>";
    exit();
}
