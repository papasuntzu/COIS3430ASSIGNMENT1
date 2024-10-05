<?php
session_start();

// Initializing the quiz
if (!isset($_SESSION['questions'])) {
    $_SESSION['score'] = 0;
    $_SESSION['feedback'] = array(); 
    $_SESSION['curr_qns'] = 0;

    // Defining questions and answers
    $_SESSION['questions'] = [
        [
            'question' => 'Select the wrongly spelt word?',
            'options' => ['calander', 'career', 'callous', 'carriage'],
            'answer' => 'calander'
        ],
        [
            'question' => 'Hardware is any part of the computer that has a physical structure that can be seen and touched?',
            'options' => ['True', 'False', 'Not sure', 'None of the above'],
            'answer' => 'True'
        ],
        [
            'question' => '______ devices accept data and instructions from the user?',
            'options' => ['Output', 'Input', 'Components of hardware', 'Storage'],
            'answer' => 'Input'
        ],
        [
            'question' => 'Which element has the chemical symbol "O"?',
            'options' => ['Oxygen', 'Gold', 'Silver', 'Hydrogen'],
            'answer' => 'Oxygen'
        ],
        [
            'question' => '_____ is the processed form of data which is organized, meaningful, and useful.',
            'options' => ['Software', 'Data', 'Information', 'None of the above'],
            'answer' => 'Information'
        ]
    ];
}

// Handle user responses
if (isset($_POST['submit'])) {
    $curr_qns = $_SESSION['curr_qns'];
    $user_answer = $_POST['answer'];
    $correct_answer = $_SESSION['questions'][$curr_qns]['answer'];

    // Checking if the answer is correct
    if ($user_answer === $correct_answer) {
        $_SESSION['score']++;
        $_SESSION['feedback'][$curr_qns] = [
            'question' => $_SESSION['questions'][$curr_qns]['question'],
            'user_ans' => $user_answer,
            'correct' => true
        ];
    } else {
        $_SESSION['feedback'][$curr_qns] = [
            'question' => $_SESSION['questions'][$curr_qns]['question'],
            'user_ans' => $user_answer,
            'correct' => false,
            'correct_answer' => $correct_answer
        ];
    }

    // Move to the next question
    $_SESSION['curr_qns']++;

    // Check if quiz is over and redirect to results
    if ($_SESSION['curr_qns'] >= count($_SESSION['questions'])) {
        header("Location: results.php");
        exit;
    }
}

// Show current question
$curr_qns = $_SESSION['curr_qns'];
$curr_qnshtml = $_SESSION['questions'][$curr_qns];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz - Question <?= $curr_qns + 1 ?></title>
    <link rel="stylesheet" href="./styles/part2.css">
</head>
<body>
    <h1>Question <?= $curr_qns + 1 ?>:</h1>
    <h2><?= $curr_qnshtml['question'] ?></h2>
    <form method="POST">
        <?php foreach ($curr_qnshtml['options'] as $option): ?>
            <input type="radio" name="answer" value="<?= $option ?>" required> <?= $option ?><br>
        <?php endforeach; ?>
        <input name="submit" type="submit" value="Submit">
    </form>
</body>
</html>
