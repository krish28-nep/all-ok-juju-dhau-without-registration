<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "juju-dhau";

// Correcting the typo in the variable name
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // Uncomment this line if you want a console log for successful connection
    // echo "<script>console.log('Connected Successfully')</script>";
}
?>
