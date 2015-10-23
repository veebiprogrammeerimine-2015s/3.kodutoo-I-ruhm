<?php
require_once("../config_global.php");
	$database = "if15_ole";

session_start();
	
function loginUser($email, $password_hash){
	
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT id, email FROM mvp WHERE email=? AND password=?");
	$stmt->bind_param("ss", $email, $password_hash);
	$stmt->bind_result($id_from_db, $email_from_db);
	$stmt->execute();
		if($stmt->fetch()){
			echo "kasutaja id=".$id_from_db;
			
		$_SESSION["id_from_db"] = $id_from_db;
		$_SESSION["user_email"] = $email_from_db;
			header("Location: data.php");
		}else{
			echo "Wrong password or email!";
		}
		$stmt->close();
		$mysqli->close();
}

function createUser($create_email, $password_hash){
	
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);	
	$stmt = $mysqli->prepare("INSERT INTO mvp (email, password) VALUES (?, ?)");
	$stmt->bind_param("ss", $create_email, $password_hash);
	$stmt->execute();
		$stmt->close();		
		$mysqli->close();		
}
 
function createNote($note, $done){
        
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("INSERT INTO notes (user_id, note, done) VALUES (?,?,?)");
	$stmt->bind_param("iss", $_SESSION["id_from_db"], $note, $done);
        $message = "";
        if($stmt->execute()){
            $message = "Note saved!!";
        }else{
			echo $stmt->error;
		}
        return $message;
        $stmt->close();
        $mysqli->close();
}
	
function getAllData(){
        	
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT id, user_id, note, done FROM notes WHERE deleted IS NULL AND user_id={$_SESSION["id_from_db"]}");
	$stmt->bind_result($id_from_db, $user_id_from_db, $note_from_db, $done_from_db);
	$stmt->execute();
	
	$array = array();
	$row_nr = 0;
	
	while($stmt->fetch()){
		$note = new StdClass();
		$note->id = $id_from_db;
		$note->note = $note_from_db;
		$note->done = $done_from_db;
		$note->user_id = $user_id_from_db;
		
		array_push($array, $note);
		//echo"<pre>";
		//var_dump($array);
		//echo"</pre>";
	}
	return $array;
	$stmt->close();
	$mysqli->close();
}

function deleteNote($id_to_be_deleted){

$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);

$stmt = $mysqli->prepare("UPDATE notes SET deleted=NOW() WHERE id=?");
$stmt->bind_param("i", $id_to_be_deleted);

if($stmt->execute()){
	header("Location: table.php");	
}
$stmt->close();
$mysqli->close();
}

function getSearchData($keyword=""){
	  
	$search = "";
	if($keyword == ""){
		$search = "%%";

	}else{
		$search = "%".$keyword."%";
	}
	
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT id, user_id, note, done FROM notes WHERE deleted IS NULL AND (note LIKE ? OR done like ?)");
	$stmt->bind_param("ss", $search, $search);
	$stmt->bind_result($id_from_db, $user_id_from_db, $note_from_db, $done_from_db);
	$stmt->execute();
	$array = array();
	
	while($stmt->fetch()){
		$notes_search = new StdClass();
		
		$notes_search->id = $id_from_db;
		$notes_search->note = $note_from_db; 
		$notes_search->user_id = $user_id_from_db; 
		$notes_search->done = $done_from_db; 
		
		array_push($array, $notes_search);
		//var_dump($array);
	}
	
	return $array;
	$stmt->close();
	$mysqli->close();
}

?>