<?php
include 'db_connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
    die("Invalid property ID.");
}

$sql = "DELETE FROM Properties WHERE property_id = $id";
if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
    exit();
} else {
    echo "❌ Error deleting record: " . $conn->error;
}
?>