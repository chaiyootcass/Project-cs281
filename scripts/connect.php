<?php
$db_host = "localhost";
$db_username = "root";
$db_pass = "";
$db_name = "cd";
$con = mysqli_connect("$db_host", "$db_username", "$db_pass") or die("could not connect to mysql");
mysqli_select_db($con, "$db_name") or die("no database");
