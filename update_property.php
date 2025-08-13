<?php
include 'db_connect.php';

$id = intval($_POST['id']);
$owner_id = intval($_POST['owner_id']);
$agent_id = empty($_POST['agent_id']) ? 'NULL' : intval($_POST['agent_id']);
$address = $conn->real_escape_string($_POST['address']);
$city = $conn->real_escape_string($_POST['city']);
$state = $conn->real_escape_string($_POST['state']);
$zipcode = $conn->real_escape_string($_POST['zipcode']);
$property_type = $conn->real_escape_string($_POST['property_type']);
$bedrooms = intval($_POST['bedrooms']);
$bathrooms = intval($_POST['bathrooms']);
$area_sqft = floatval($_POST['area_sqft']);
$price = floatval($_POST['price']);
$description = $conn->real_escape_string($_POST['description']);

$sql = "UPDATE Properties SET
            owner_id = $owner_id,
            agent_id = $agent_id,
            address = '$address',
            city = '$city',
            state = '$state',
            zipcode = '$zipcode',
            property_type = '$property_type',
            bedrooms = $bedrooms,
            bathrooms = $bathrooms,
            area_sqft = $area_sqft,
            price = $price,
            description = '$description'
        WHERE property_id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
    exit();
} else {
    echo "❌ Error updating record: " . $conn->error;
}
?>