<?php 
    session_start();
    require_once __DIR__ . "/includes/functions.php";
    include("./includes/header.html");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css">
    <title>TEST</title>
</head>
<body>
    <div class="login-form">
        <form action="auth/login.php" method="post">
            <input type="text" name="username" placeholder="Enter Name:">
            <input type="password" name="pass" placeholder="Enter Password:">
            <button>Log in</button>
        </form>
    </div>
    <br>
    <br>
        <form action="index.php" method="post">
            <button type="submit" name="registration">Register</button>
        </form>
    <br>
    <br>
    <hr>
    <h1>$_SERVER Keys and Values, for debuging</h1>

    <div>
        <h1>THIS IS A TEST IF DEPLOYMENT AUTOMATION WORKS!!!</h1>
    </div>

    <div class="test">
        <form>
            <input type="text" name="username" placeholder="Enter Name:">
            <input type="password" name="pass" placeholder="Enter Password:">
            <input type="email" name="email" placeholder="Enter Email:">
            <button>Register</button>
        </form>
</body>
</html>
<?php

    include("./includes/footer.html");

    if($_SERVER["REQUEST_METHOD"] === "POST")
    {
        if(isset($_POST['registration']))
        {
            redirectToPage("auth/register.php");
            exit();
        }
    }

    foreach($_SERVER as $key => $value)
    {
        echo"{$key} = {$value} <br><br>";
    }
?>
