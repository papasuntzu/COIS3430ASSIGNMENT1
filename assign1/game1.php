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