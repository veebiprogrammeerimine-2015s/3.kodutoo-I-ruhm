<?php

    require_once("functions.php");
    
    if(!isset($_SESSION['logged_in_user_username'])){
        header("Location: login.php");
    }
    
    if(isset($_GET["logout"])){
        session_destroy();
        header("Location: login.php");
    }

    function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
 
	if(isset($_GET["delete"])){
		deleteNote($_GET["delete"]);
	}
	
	if(isset($_GET["addnew"])){
		createNote($_SESSION["logged_in_user_username"], $_GET["title"], $_GET["text"]);
	}
 
	if(isset($_GET["update"])){
		updateNote($_GET["username"], $_GET["title"], $_GET["text"]);
	}
	
 	$note_array = getAllData();
?>

Tere, <?=$_SESSION['logged_in_user_username'];?> <a href="?logout=1">Logi välja</a><br><br>
Sellel lehel saad hoida enda memosi/kirjutisi.<br>
NB! Tekst saab olla kuni 255 tähte pikk!<br><br>
<html>
<form method='get'>
<textarea cols="50" rows="1" id="title" name="title" type="title" placeholder="Pealkiri..." maxlength="255">
</textarea><br><br>
<textarea cols="50" rows="5" id="text" name="text" type="text" placeholder="Alusta kirjutamist..." maxlength="255">
</textarea><br>
<input id="addnew" name="addnew" type="submit" value="Save"><br>
</form>

<h1>Hiljutised memod</h1>

<table border=1>
<tr>
	<th>Kasutaja</th>
	<th>Pealkiri</th>
	<th>Sisu</th>
	<th>Aeg</th>
	<th>Kustuta</th>
	<th>Muuda</th>
</tr>
<?php

	for($i = 0; $i < count($note_array); $i++){
		if(isset($_SESSION["logged_in_user_username"]) && $note_array[$i]->username == $_SESSION["logged_in_user_username"]){
			
		if(isset($_GET["edit"]) && $_GET["edit"] == $note_array[$i]->id){
			echo "<tr>";
			echo "<form action='data.php' method='get'>";

			echo "<input type='hidden' name='username' value='".$note_array[$i]->id."'>";
			echo "<td>".$note_array[$i]->username."</td>";
			echo "<td><input name='title' value='".$note_array[$i]->title."' ></td>";
			echo "<td><input name='text' value='".$note_array[$i]->text."' ></td>";
			echo "<td><input name='update' type='submit'></td>";
            echo "<td><a href='data.php'>cancel</a></td>";
			echo "</form>";
            echo "</tr>";
		}else{
		echo "<tr>";
		echo "<td>".$note_array[$i]->username."</td>";
		echo "<td>".$note_array[$i]->title."</td>";
		echo "<td>".$note_array[$i]->text."</td>";
		echo "<td>".$note_array[$i]->time."</td>";
		echo "<td><a href='?delete=".$note_array[$i]->id."'>Delete</a></td>";
		echo "<td><a href='?edit=".$note_array[$i]->id."'>Change</a></td>";
		}
		
		echo "</tr>";
		}
	}

?>
</table>