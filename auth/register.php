<?php

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    //like #include <>
    require_once __DIR__ . "/../config/Database.php";
    require_once __DIR__ . "/../Classes/RegisterClass.php";

    $password = htmlspecialchars($_POST["pass"]);
    $userName = htmlspecialchars($_POST["username"]);
    $email = htmlspecialchars($_POST["email"]);

    $reg = new Register($password, $userName, $email);

    if($reg->registerUser())
    {
        echo "REGISTRATION SUCCESS!!!";
    }
    else
    {
        echo "REGISTRATION Failed :(";
    }

}