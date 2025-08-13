<?php
include 'db_connect.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Customer</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Customer</h1>
        <form action="insert_customer.php" method="POST" class="form">
            <label>Name</label>
            <input type="text" name="name" required>
            <label>Phone</label>
            <input type="text" name="phone" required>
            <label>Email</label>
            <input type="email" name="email">
            <label>Minimum Budget</label>
            <input type="number" step="1000" name="budget_min">
            <label>Maximum Budget</label>
            <input type="number" step="1000" name="budget_max">
            <label>Preferred Location</label>
            <input type="text" name="preferred_location">
            <label>Customer Type</label>
            <select name="customer_type" required>
                <option value="Buyer">Buyer</option>
                <option value="Renter">Renter</option>
            </select>
            <button type="submit" class="btn">Add Customer</button>
        </form>
        <p><a href="index.php">← Back to List</a></p>
    </div>
</body>
</html>