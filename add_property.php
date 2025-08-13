<?php
include 'db_connect.php';
$owners = $conn->query("SELECT owner_id, name FROM Owners");
$agents = $conn->query("SELECT agent_id, name FROM Agents WHERE status = 'Active'");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Property</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Property</h1>
        <form action="insert_property.php" method="POST" class="form">
            <label>Owner</label>
            <select name="owner_id" required>
                <option value="">Select Owner</option>
                <?php while ($owner = $owners->fetch_assoc()): ?>
                    <option value="<?= $owner['owner_id'] ?>"><?= htmlspecialchars($owner['name']) ?></option>
                <?php endwhile; ?>
            </select>
            <label>Agent</label>
            <select name="agent_id">
                <option value="">Select Agent (Optional)</option>
                <?php while ($agent = $agents->fetch_assoc()): ?>
                    <option value="<?= $agent['agent_id'] ?>"><?= htmlspecialchars($agent['name']) ?></option>
                <?php endwhile; ?>
            </select>
            <label>Address</label>
            <input type="text" name="address" required>
            <label>City</label>
            <input type="text" name="city" required>
            <label>State</label>
            <input type="text" name="state" required>
            <label>Zipcode</label>
            <input type="text" name="zipcode">
            <label>Property Type</label>
            <select name="property_type" required>
                <option value="House">House</option>
                <option value="Apartment">Apartment</option>
                <option value="Commercial">Commercial</option>
                <option value="Land">Land</option>
            </select>
            <label>Bedrooms</label>
            <input type="number" name="bedrooms" required>
            <label>Bathrooms</label>
            <input type="number" name="bathrooms" required>
            <label>Area (sqft)</label.input>
            <input type="number" step="0.01" name="area_sqft" required>
            <label>Price</label>
            <input type="number" step="0.01" name="price" required>
            <label>Description</label>
            <textarea name="description"></textarea>
            <button type="submit" class="btn">Add Property</button>
        </form>
        <p><a href="index.php">← Back to List</a></p>
    </div>
</body>
</html>