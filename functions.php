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
            $message = "Edukalt andmebaasi salvestatud!";
        }else{
			echo $stmt->error;
		}
        return $message;
        $stmt->close();
        $mysqli->close();
        
}
	
function getAllData(){
        
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT id, user_id, note, done FROM notes");
    $stmt->bind_result($id_from_db, $user_id_from_db, $note_from_db, $done_from_db);
	$stmt->execute();
		while($stmt->fetch()){
        }
    $stmt->close();
    $mysqli->close();
    }
?>