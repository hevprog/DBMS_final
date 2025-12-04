<?php

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    //like #include <>
    require_once "./config/Database.php";
    require_once "./Classes/LoginClass.php";

    $userName = $_POST["username"];
    $password = $_POST["password"];

    $login = new Login($userName, $password);

    
}