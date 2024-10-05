<?php

require_once './includes/library.php';
$pdo = connectdb();

$select="SELECT name, score FROM scores ORDER BY score DESC LIMIT 20";
$stmt= $pdo->prepare($select);
$stmt->execute();
$results = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>High Scores</title>
    <link rel="stylesheet" href="./styles/main.css">
</head>
<body>
    <div class="scorescontainer">
        <h1>High Scores</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $score): ?>
                    <tr>
                        <td><?php echo $score['name']; ?></td>
                        <td><?php echo $score['score']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="game1.php">Play Again</a>
    </div>
</body>
</html>