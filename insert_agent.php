<?php
include 'db_connect.php';

$name = $conn->real_escape_string($_POST['name']);
$phone = $conn->real_escape_string($_POST['phone']);
$email = $conn->real_escape_string($_POST['email']);
$commission_rate = floatval($_POST['commission_rate']);
$hire_date = $conn->real_escape_string($_POST['hire_date']);
$experience_years = intval($_POST['experience_years']);

$sql = "INSERT INTO Agents (name, phone, email, commission_rate, hire_date, experience_years)
        VALUES ('$name', '$phone', '$email', $commission_rate, '$hire_date', $experience_years)";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
    exit();
} else {
    echo "❌ Error: " . $conn->error;
}
?>