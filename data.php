<?php
$page_title = "data";
$page_file_name = "data.php";

require_once("functions.php");

    
if(isset($_GET["logout"])){
	session_destroy();
		header("Location: login.php");
}
if(isset($_GET["notes"])){
		header("Location: table.php");
}

    $note = $done = $m = "";
    $note_error = $done_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	if(isset($_POST["add_note"])){
		
		if ( empty($_POST["note"]) ) {
			$note_error = "Note on kohustuslik";
		}else{
			$note = cleanInput($_POST["note"]);
		}
		
		if ( empty($_POST["done"]) ) {
			$done_error = "Done on kohustuslik";
		}else{
			$done = cleanInput($_POST["done"]);
		}
		
		if($note_error == "" && $done_error == ""){
			$m = createNote($note, $done);
			
			if($m != ""){
				$note = "";
				$done = "";
			}
		}
	}
}

function cleanInput($data) {
	$data = trim($data);
    $data = stripslashes($data);
	$data = htmlspecialchars($data);
    return $data;
    }
    
    getAllData();


?>	
<a href="?logout=1">Logout</a><br><br>
<a href="?notes=">Notes</a>

<h2>Add</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <label for="note"> Note </label>
  	<input id="note" name="note" type="text" size="60" value="<?=$note;?>"> <?=$note_error;?><br><br>
	<label for="done"> Done already? </label>
    <select id="done" name="done" type="text" value="<?=$done;?>"> <?=$done_error;?><br><br>
	  <option value="no">No</option>
	  <option value="yes">Yes</option>
	</select><br><br>
  	<input type="submit" name="add_note" value="Add">
    <p>	<?=$m;?></p>
  </form>