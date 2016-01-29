<?php
    require_once("functions.php");
    require_once("../config.php");
    $database = "if15_richaas_1";

    $mysqli = new mysqli($servername, $username, $password, $database);
    
    // Kas kasutaja on sisse loginud?
    if(!isset($_SESSION['logged_in_user_id'])){
        header("Location: login.php");
    }

    // ?logout=1
    if(isset($_GET["logout"])){
        //kustutame sessiooni muutujad
        $mysqli->close();
        session_destroy();
        header("Location: login.php");
    }
?>

Tere, <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1">Logi välja</a>
