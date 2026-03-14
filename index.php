<?php
require "dbconnect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>F1_project — Чемпионат Формулы 1</h1>

    <?php
    echo "<h2>Grand Prix</h2>";

    $result = $conn->query("SELECT * FROM t_grand_prix");

    while ($row = $result->fetch()) {
    ?>

    <?php
    }
    ?>
</body>
</html>