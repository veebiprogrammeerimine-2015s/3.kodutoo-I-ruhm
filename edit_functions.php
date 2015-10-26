<?php
require_once("../config_global.php");
$database = "if15_ole";

function getSingleNote($id){
	
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT note, done FROM notes WHERE id=? AND deleted IS NULL");
	$stmt->bind_param("i", $id);
	$stmt->bind_result($note, $done);
	$stmt->execute();
	
	$note_edit = new StdClass();
	
	if($stmt->fetch()){	
		$note_edit->note = $note;
		$note_edit->done = $done;
	}else{
		header("Location: table.php");
	}
	$stmt->close();
	$mysqli->close();
	return $note_edit;
	
}

   function updateNote($note_id, $note, $done){
	
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("UPDATE notes SET note=?, done=? WHERE id=?");
	$stmt->bind_param("ssi", $note, $done, $note_id);
	$stmt->execute();
	
	header("Location: table.php");
	
	$stmt->close();
	$mysqli->close();
	
}

 ?>