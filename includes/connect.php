<?php
$servername = "localhost"; // Change if your database is hosted elsewhere
$username = "root"; // Your database username
$password = ""; // Your database password
$database = "mystore"; // Your database name

// Create connection
$con = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>  