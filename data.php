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

    $todo = $date = '';
    $todo_error = $date_error = '';
?>

Tere, <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1">Logi välja</a>

<h2>Todo:</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <label for="todo">To do content:</label>
   	<input id="todo" name="todo" type="text" value="<?=$todo;?>"> <?=$todo_error;?><br><br>
   	<label for="date"> Esitamise kuupäev </label>
    <input id="date" name="date" type="text" value="<?=$date;?>"> <?=$date_error;?><br><br>
   	<input type="submit" name="add_todo" value="Lisa">
  </form>
