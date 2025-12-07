<?php
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    //like #include <>
    require_once __DIR__ . "/../config/database.php"; //small d
    require_once __DIR__ . "/../Classes/LoginClass.php";
    require_once __DIR__ . "/../includes/functions.php";

    session_start();

    $_SESSION["username"] = htmlspecialchars($_POST["username"]);
    $_SESSION["password"] = htmlspecialchars_decode($_POST["pass"]);



    $login = new Login($_SESSION["username"], $_SESSION["password"]);

    if($login->authenticateUser())
    {

        if($login->getUserStatus()['status'] == "customer")
        {
            redirectToPage("../pages/products.php");
	        exit();
        }
        else
        {
            redirectToPage("../pages/admin.php");
	        exit();
        }

    }
    else
    {
        header("Location: ../index.php");
        exit();
    }

}

