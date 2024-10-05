# Shubarna Sunuwar 0781476

# Part 1.
![Image](./md%20pic/q1.1.png)
### Without searching
![Image](./md%20pic/q1%20text%20only.png)
### With searching
![Image](./md%20pic/q1%20search.png)

## Code
```php
<?php
if (isset($_POST['submit'])) {
    $file = $_FILES['file']['tmp_name'];
    $search = isset($_POST['search']) ? $_POST['search'] : '';

    if (is_uploaded_file($file)) {
        $fileread = fopen($file, 'r');
        $lines = array();
        $matched = array();
        $unmatchedCount = 0;

        // Read file and storing
        while (!feof($fileread)) {
            $line = trim(fgets($fileread));
            if ($line !== "") {
                $lines[] = $line; 
            }
        }
        fclose($fileread);

        // if no search
        if (empty($search)) {
            foreach ($lines as $line) {
                echo "<span><strong>Original String: $line</strong></span>";
                $wordCount = str_word_count($line);
                echo "<div>Number of words: $wordCount</div>";

                // Count letter 'a'
                $aCount = substr_count(strtolower($line), 'a');
                echo "<div>Number of 'a's: $aCount</div>";

                // Count punctuation
                $punct_count = 0;
                for ($i = 0; $i < strlen($line); $i++) {
                    $ascii = ord($line[$i]);
                    if (($ascii >= 33 && $ascii <= 47) || ($ascii >= 58 && $ascii <= 64) ||
                        ($ascii >= 91 && $ascii <= 96) || ($ascii >= 123 && $ascii <= 126)) {
                        $punct_count++;
                    }
                }
                echo "<div>Punctuation count: $punct_count</div>";

                // Sort words in descending order
                $words = explode(' ', $line);
                usort($words, function ($a, $b) {
                    return strtolower($b) <=> strtolower($a);
                });
                echo "<div>Words in descending order: " . implode(' ', $words) . "</div>";

                // Middle third of the string
                $length = strlen($line);
                $third = floor($length / 3);
                $middleStart = $third;
                echo "<div>Middle third: " . substr($line, $middleStart, $third) . "</div>";
            }
        } else {
            // If a search term is provided, output only matching lines
            foreach ($lines as $line) {
                if (stripos($line, $search) !== false) {
                    // Highlight the search term
                    $highlighted = str_ireplace($search, "<span class='highlight'>$search</span>", $line);
                    echo "<div>Search Result: $highlighted</div>";
                    $matched[] = $line;
                } else {
                    $unmatchedCount++;
                }
            }

            // Output the count of lines without the search term
            echo "<div>Number of lines without the search term '<strong>$search</strong>': $unmatchedCount</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Search</title>
    <link rel="stylesheet" href="./styles/part1.css">
    <style>
        .highlight {
            background-color: yellow;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <form class="formcontainer" action="part1.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="searchlabel">Search: </label>
            <input type="text" name="search" id="searchlabel"><br>
        </div>
        <div>
            <label for="filelabel">Upload File: </label>
            <input type="file" name="file" id="filelabel">
        </div>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>

```

# Part 2
### Must choose a answer
![Image](./md%20pic/q2%20have%20to%20select%20answer.png)

### Feedback after the quiz is finished
![Image](./md%20pic/q2%20feedback.png)

### Sql
![Image](./md%20pic/q3%20sql.png)
![Image](./md%20pic/q3%20sql2.png)
## Code:

## Code:

## Quiz code
```php
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

```
### Result code
```php
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

```
# Part 3

### Overall UI
![Image](./md%20pic/q3%20overall.png)
### Midgame
![Image](./md%20pic/q3%20midgame.png)
### Redirects to gameover page after 10 losses
![Image](./md%20pic/q3%20redirecting.png)
### Name and valid email must be entered
![Image](./md%20pic/q3%20must%20enter%20name%20email.png)
![Image](./md%20pic/q3%20must%20enter%20namee.png)
![Image](./md%20pic/q3%20must%20enter%20nameee.png)

### This is the highscore page
![Image](./md%20pic/q3%20high%20score.png)

## Code

### Game code
```php
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $_SESSION['wins'] = 0;
    $_SESSION['losses'] = 0;
    $_SESSION['draws']= 0;
    $_SESSION['game_num'] = 1;
    $_SESSION['feedback'] = '';
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $choices = ['paper', 'scissors', 'rock'];
    $userchoice=$_POST['choice'];
    $randnum=array_rand($choices);
    $compchoice=$choices[$randnum];
    if($userchoice===$compchoice){
        $result = "tied";
        $_SESSION['draws']++;
    }
    elseif(
        ($userchoice === 'rock' && $compchoice === 'scissors') ||
        ($userchoice === 'scissors' && $compchoice === 'paper') ||
        ($userchoice === 'paper' && $compchoice === 'rock')
    ){
        $result = "won";
        $_SESSION['wins']++;
    }
    else{
        $result = "lost!";
        $_SESSION['losses']++;
    }
    $_SESSION['game_num']++;
    $previousgame=$_SESSION['game_num']-1;
    $_SESSION['feedback'] = "You $result game $previousgame: You chose $userchoice, Computer chose $compchoice.";
    
    if($_SESSION['losses']==10){
    
        echo "<h1> 10 Losses.Game Over!";
        header('Refresh: 5; url=game_over.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rock Paper Scissors</title>
    <link rel="stylesheet" href="./styles/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="gamecontainer">
        <h1>Rock Paper Scissors</h1>
        <h2>Game <?= $_SESSION['game_num']?>: </h2>
        <h2>Wins: <?=$_SESSION['wins']?> | Losses: <?=$_SESSION['losses']?> | Draws: <?=$_SESSION['draws']?></h2>
        <form action="game1.php" method="POST">
            <div class="form-buttons">
                <button type="submit" name="choice" value="paper">
                    <i class="fa-solid fa-hand"></i> Paper
                </button>
                <button type="submit" name="choice" value="scissors">
                    <i class="fa-solid fa-hand-scissors"></i> Scissors
                </button>
                <button type="submit" name="choice" value="rock">
                    <i class="fa-solid fa-hand-back-fist"></i> Rock
                </button>
            </div>
        </form>
        <p><?php echo $_SESSION['feedback']; ?></p>
        <a href="game1.php">Start Again</a> | <a href="high_scores.php">High Scores</a>
    </div>
</body>
</html>
```

### Game Over code
```php
<?php
session_start();

$name=$_POST['name'] ?? "";
$email=$_POST['email'] ?? "";
$errors=array();


//when form is submitted
if (isset($_POST['submit'])) {

    if (empty($name)) {
        $errors['name'] = true;
    }

    if (empty(filter_var($email, FILTER_VALIDATE_EMAIL))) {
        $errors['email'] = true;
    }
    require_once './includes/library.php';
    $pdo = connectdb();

    if (empty($errors)) {
        $insert = "INSERT INTO `scores` (`name`,`email`, `score`) VALUES (?,?,?)";
        $stmt= $pdo->prepare($insert);
        $stmt->execute([$name, $email, $_SESSION['wins']]);
    
        header('Location: high_scores.php');
        exit;
    } else {
        $error = 'Please provide a valid name and email.';
    }



      
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Over</title>
    <link rel="stylesheet" href="./styles/main.css">
</head>
<body>
    <div class="formcontainer">
        <h1>Game Over</h1>
        <form method="post" action="game_over.php">
            <div>
                <label for="namelabel">Name:</label>
                <input type="text" id="namelabel" name="name">
                <span class="error <?= !isset($errors['name']) ? 'hidden' : '' ?>">
                You must enter a name.
                </span>
            </div>

            <div>
                <label for="emaillabel">Email:</label>
                <input type="email" id="emaillabel" name="email">
                <span class="error <?= !isset($errors['email']) ? 'hidden' : '' ?>">
                You must enter an email.
                </span>
            </div>

            <input type="submit" name="submit" value="Save Score">
        </form>
    </div>
</body>
</html>


```

### High score code
```php
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

```
