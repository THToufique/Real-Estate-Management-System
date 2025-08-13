<?php
include 'db_connect.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Agent</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Agent</h1>
        <form action="insert_agent.php" method="POST" class="form">
            <label>Name</label>
            <input type="text" name="name" required>
            <label>Phone</label>
            <input type="text" name="phone" required>
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Commission Rate (%)</label>
            <input type="number" step="0.1" name="commission_rate" required>
            <label>Hire Date</label>
            <input type="date" name="hire_date" required>
            <label>Experience (Years)</label>
            <input type="number" name="experience_years" required>
            <button type="submit" class="btn">Add Agent</button>
        </form>
        <p><a href="index.php">← Back to List</a></p>
    </div>
</body>
</html>