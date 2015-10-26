<?php
require_once("edit_functions.php");
 
 if(isset($_GET["update"])){
	updateNote($_GET["note_id"], $_GET["note"], $_GET["done"]);
}

if(isset($_GET["edit_id"])){
	
	$note_edit = getSingleNote($_GET["edit_id"]);	
	
}else{
	
	header("Location: table.php");
}

if(isset($_GET["notes"])){
	header("Location: table.php");
}

?>
<a href="?notes=">Notes</a><br><br>
<form action="edit.php" method="get" >
    <input name="note_id" type="hidden" value="<?=$_GET["edit_id"];?>">
    <input name="note" type="text" value="<?=$note_edit->note;?>" ><br><br>
    <select id="done" name="done" type="text" value="<?=$note_edit->done;?>"><br>
	  <option value="no">No</option>
	  <option value="yes">Yes</option>
	</select><br><br>
    <input name="update" type="submit" >
</form>
