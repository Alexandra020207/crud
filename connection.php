<?php
$con = mysqli_connect("localhost", "root", "", "ticket");

if (mysqli_connect_errno()) {
    die("Cannot Connect to Database: " . mysqli_connect_error());
}

define("UPLOAD_SRC", $_SERVER['DOCUMENT_ROOT'] . "/crud/uploads/");
?>

