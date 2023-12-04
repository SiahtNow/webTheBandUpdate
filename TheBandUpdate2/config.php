<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "the_band_update";

    $conn = new mysqli($servername, $username, $password, $db);

    if(!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>