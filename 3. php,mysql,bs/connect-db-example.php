<?php
date_default_timezone_set("Asia/Kolkata");
$link = mysqli_connect("localhost", "root", "", "tablename");

// Check connection
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}