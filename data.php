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

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(isset($_POST["add_todo"])){
            if ( empty($_POST["todo"]) ) {
                $todo_error = "Ei saa mitte midagi lisada.";
            }else{
                $todo = cleanInput($_POST["todo"]);
            }

            if ( empty($_POST["date"]) ) {
                $date_error = "Kuupäev puudu!";
            }else{
                $date = cleanInput($_POST["date"]);
            }

            //erroreid ei olnud käivitan funktsiooni,
            //mis sisestab andmebaasi
            if($todo_error == $date_error){
                // m on message mille saadame functions.php
                $m = newTodoData($todo, $date);

                if($m != ""){
                    // teeme vormi tühjaks
                    $todo = "";
                    $date = "";
                }
            }

        }
    }
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
