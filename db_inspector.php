<?php
include 'db_connect.php';

$tables = [];
$tablesRes = $conn->query("SHOW TABLES");
while ($row = $tablesRes->fetch_array()) {
    $tables[] = $row[0];
}

$schema = [];
foreach ($tables as $tbl) {
    $colsRes = $conn->query("SHOW COLUMNS FROM `$tbl`");
    while ($col = $colsRes->fetch_assoc()) {
        $schema[$tbl][] = $col;
    }
}

$querySQL = "";
$resultRows = [];
$resultFields = [];
$errorMsg = "";

if (!empty($_POST['sql'])) {
    $querySQL = trim($_POST['sql']);
    if (preg_match('/^\s*select/i', $querySQL)) {
        $queryRes = $conn->query($querySQL);
        if ($queryRes) {
            $resultFields = $queryRes->fetch_fields();
            while ($row = $queryRes->fetch_assoc()) {
                $resultRows[] = $row;
            }
        } else {
            $errorMsg = $conn->error;
        }
    } else {
        $errorMsg = "Only SELECT statements are allowed in this console.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DB Inspector</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Database Inspector</h1>
        <p><a href="index.php" class="btn">← Back to Property List</a></p>
        <?php foreach ($schema as $tbl => $cols): ?>
            <details>
                <summary><?= $tbl ?></summary>
                <table>
                    <thead><tr><th>Field</th><th>Type</th><th>Key</th><th>Null</th><th>Default</th><th>Extra</th></tr></thead>
                    <tbody>
                        <?php foreach ($cols as $c): ?>
                            <tr>
                                <td><?= $c['Field'] ?></td>
                                <td><?= $c['Type'] ?></td>
                                <td><?= $c['Key'] ?></td>
                                <td><?= $c['Null'] ?></td>
                                <td><?= $c['Default'] ?></td>
                                <td><?= $c['Extra'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </details>
        <?php endforeach; ?>
        <div class="console">
            <h2>Run a SELECT query</h2>
            <form method="POST">
                <textarea name="sql" placeholder="e.g. SELECT * FROM Properties LIMIT 5"><?= htmlspecialchars($querySQL) ?></textarea>
                <button type="submit" class="btn">Run</button>
            </form>
            <?php if ($errorMsg): ?>
                <p class="error">❌ <?= $errorMsg ?></p>
            <?php elseif ($querySQL): ?>
                <h3>Results (<?= count($resultRows) ?> rows)</h3>
                <?php if ($resultRows): ?>
                    <table class="resultTable">
                        <thead>
                            <tr>
                                <?php foreach ($resultFields as $f): ?>
                                    <th><?= $f->name ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultRows as $r): ?>
                                <tr>
                                    <?php foreach ($r as $cell): ?>
                                        <td><?= htmlspecialchars($cell) ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No rows returned.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <p style="margin-top:20px;"><a href="index.php">← Back to Property List</a></p>
    </div>
</body>
</html>