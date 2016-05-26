<?php
$servername = "localhost";
$username = "wlasny_admin";
$password = "PetConnect1";
$dbname = "wlasny_petconnect";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}