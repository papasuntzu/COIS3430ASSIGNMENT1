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
