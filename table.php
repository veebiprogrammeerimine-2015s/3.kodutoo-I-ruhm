<?php
  require_once("functions.php");

  // Kas kasutaja on sisse loginud?
  if(!isset($_SESSION['logged_in_user_id'])){
      header("Location: login.php");
  }

	if(isset($_GET["delete"])){
		deleteTodoData($_GET["delete"]);
	}
	if(isset($_GET["update"])){
    updateTodoData($_GET["todo_id"], $_GET["todo"], $_GET["date"]);
	}

	$keyword = "";
  if(isset($_GET["keyword"])){
    $keyword = $_GET["keyword"];

    // otsime
    $todo_array = getAllData($keyword);

	}else{
	  $todo_array = getAllData($keyword);
	}

	if(isset($_GET["logout"])){
        //kustutame sessiooni muutujad
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

          if($todo_error == $date_error){
              newTodoData($_SESSION['logged_in_user_id'], $todo, $date);
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
    <input id="date" name="date" type="date" value="<?=$date;?>"> <?=$date_error;?><br><br>
   	<input type="submit" name="add_todo" value="Lisa">
  </form>

<h1>Tabel</h1>

<form action="table.php" method="get">
    <input name="keyword" type="search" value="<?=$keyword?>" >
    <input type="submit" value="otsi">
<form>

<table border=1>
<tr>
	<th>ID</th>
	<th>Kasutaja ID</th>
	<th>Todo sisu</th>
	<th>Esitamise tähtaeg</th>
	<th>Delete</th>
  <th>Edit</th>
</tr>

<?php
    for($i = 0; $i < count($todo_array); $i++){
        // kasutaja tahab rida muuta
        if(isset($_GET["edit"]) && $_GET["edit"] == $todo_array[$i]->id){
            echo "<tr>";
            echo "<form action='table.php' method='get'>";
            // input mida välja ei näidata
            echo "<input type='hidden' name='todo_id' value='".$todo_array[$i]->id."'>";
            echo "<td>".$todo_array[$i]->id."</td>";
            echo "<td>".$todo_array[$i]->user."</td>";
            echo "<td><input name='todo' value='".$todo_array[$i]->todo."' ></td>";
            echo "<td><input name='date' value='".$todo_array[$i]->date."' ></td>";
            echo "<td><a href='?delete=".$todo_array[$i]->id."'>X</a></td>";
            echo "<td><a href='table.php'>cancel</a></td>";
            echo "<td><input name='update' type='submit'></td>";
            echo "</form>";
            echo "</tr>";
        }else{
            // lihtne vaade
            echo "<tr>";
            echo "<td>".$todo_array[$i]->id."</td>";
            echo "<td>".$todo_array[$i]->user."</td>";
            echo "<td>".$todo_array[$i]->todo."</td>";
            echo "<td>".$todo_array[$i]->date."</td>";
            echo "<td><a href='?delete=".$todo_array[$i]->id."'>X</a></td>";
            echo "<td><a href='?edit=".$todo_array[$i]->id."'>edit</a></td>";
            echo "</tr>";

        }

    }

?>
