<?php
require_once("edit_functions.php");
 
 if(isset($_GET["update"])){
	updateNote($_GET["note_id"], $_GET["note"], $_GET["done"]);
}

if(isset($_GET["edit_id"])){
	echo $_GET["edit_id"];
	
	$note_edit = getSingleNote($_GET["edit_id"]);	
	
}else{
	
	header("Location: table.php");
	
}
?>
<form action="edit.php" method="get" >
    <input name="note_id" type="hidden" value="<?=$_GET["edit_id"];?>">
    <input name="note" type="text" value="<?=$note_edit->note;?>" ><br>
    <input name="done" type="text" value="<?=$note_edit->done;?>"><br>
    <input name="update" type="submit" >
</form>
