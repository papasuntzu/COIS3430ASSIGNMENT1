<?php
session_start();

if (!isset($_SESSION['questions'])) {
    header("Location: part2.php");
    exit;
}

$score = $_SESSION['score'];
$total_questions = count($_SESSION['questions']);
$percentage = ($score / $total_questions) * 100;

// Feedback messages based on score
if ($percentage === 100) {
    $msg = "AAA STARRRRR!";
} elseif ($percentage >= 80) {
    $msg = "Great job!";
} elseif ($percentage >= 50) {
    $msg = "Barely Passed";
} else {
    $msg = "Go study!!!";
}

// Display results
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="./styles/part2.css">
</head>
<body>
    <h2>Your Score: <?= $score ?> out of <?= $total_questions ?></h2>
    <h3><?= $msg?></h3>

    <h4>Feedback:</h4>
    <ul>
        <?php foreach ($_SESSION['feedback'] as $feedback): ?>
            <li class="<?= $feedback['correct'] ? 'correct' : 'incorrect' ?>">
                <strong><?= $feedback['question'] ?></strong><br>
                Your answer: <?= $feedback['user_ans'] ?><br>
                <?php if (!$feedback['correct']): ?>
                    Correct answer: <?= $feedback['correct_answer'] ?><br>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="part2.php">Restart Quiz</a>

    <?php
    // Clear session data
    session_unset();
    session_destroy();
    ?>
</body>
</html>
