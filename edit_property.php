<?php
include 'db_connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
    die("Invalid property ID.");
}

$result = $conn->query("SELECT * FROM Properties WHERE property_id = $id LIMIT 1");
if ($result->num_rows === 0) {
    die("Property not found.");
}
$property = $result->fetch_assoc();

$owners = $conn->query("SELECT owner_id, name FROM Owners");
$agents = $conn->query("SELECT agent_id, name FROM Agents WHERE status = 'Active'");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Property</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Property</h1>
        <form action="update_property.php" method="POST" class="form">
            <input type="hidden" name="id" value="<?= $property['property_id'] ?>">
            <label>Owner</label>
            <select name="owner_id" required>
                <option value="">Select Owner</option>
                <?php while ($owner = $owners->fetch_assoc()): ?>
                    <option value="<?= $owner['owner_id'] ?>" <?= $owner['owner_id'] == $property['owner_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($owner['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <label>Agent</label>
            <select name="agent_id">
                <option value="">Select Agent (Optional)</option>
                <?php while ($agent = $agents->fetch_assoc()): ?>
                    <option value="<?= $agent['agent_id'] ?>" <?= $agent['agent_id'] == $property['agent_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($agent['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <label>Address</label>
            <input type="text" name="address" value="<?= htmlspecialchars($property['address']) ?>" required>
            <label>City</label>
            <input type="text" name="city" value="<?= htmlspecialchars($property['city']) ?>" required>
            <label>State</label>
            <input type="text" name="state" value="<?= htmlspecialchars($property['state']) ?>" required>
            <label>Zipcode</label>
            <input type="text" name="zipcode" value="<?= htmlspecialchars($property['zipcode']) ?>">
            <label>Property Type</label>
            <select name="property_type" required>
                <option value="House" <?= $property['property_type'] == 'House' ? 'selected' : '' ?>>House</option>
                <option value="Apartment" <?= $property['property_type'] == 'Apartment' ? 'selected' : '' ?>>Apartment</option>
                <option value="Commercial" <?= $property['property_type'] == 'Commercial' ? 'selected' : '' ?>>Commercial</option>
                <option value="Land" <?= $property['property_type'] == 'Land' ? 'selected' : '' ?>>Land</option>
            </select>
            <label>Bedrooms</label>
            <input type="number" name="bedrooms" value="<?= $property['bedrooms'] ?>" required>
            <label>Bathrooms</label>
            <input type="number" name="bathrooms" value="<?= $property['bathrooms'] ?>" required>
            <label>Area (sqft)</label>
            <input type="number" step="0.01" name="area_sqft" value="<?= $property['area_sqft'] ?>" required>
            <label>Price</label>
            <input type="number" step="0.01" name="price" value="<?= $property['price'] ?>" required>
            <label>Description</label>
            <textarea name="description"><?= htmlspecialchars($property['description']) ?></textarea>
            <button type="submit" class="btn">Save Changes</button>
        </form>
        <p><a href="index.php">← Back to List</a></p>
    </div>
</body>
</html>