<?php
$host = "localhost";
$user = "root";
$password = ""; // Update with your MySQL password
$database = "RealEstateDB";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>