<?php
require_once("../config_global.php");
	$database = "if15_rasmrei";
session_start();
	
function logInUser($email, $hash){
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
    $stmt->bind_param("ss", $email, $hash);
	$stmt->bind_result($id_from_db, $email_from_db);
	$stmt->execute();
		if($stmt->fetch()){
			echo "Kasutaja logis sisse id=".$id_from_db;	
		}
    $stmt->close();    
    $mysqli->close();   
}
    
function createUser($create_email, $password_hash, $create_username){
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);	
	$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, username) VALUES (?, ?, ?)");
	$stmt->bind_param("sss", $create_email, $password_hash, $create_username);
	$stmt->execute();
	$stmt->close();		
	$mysqli->close();		
}

function createRecipe()
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);	
	$stmt = $mysqli->prepare("INSERT INTO recipe (user_id, caption, content) VALUES (?, ?, ?)");
	$stmt->bind_param("iss", $_SESSION['logged_in_user_id'], $caption, $content);
	$stmt->execute();
	$stmt->close();		
	$mysqli->close();
	$message = "";
       
        if($stmt->execute()){
            $message = "Salvestatud!";
        }else{
			echo $stmt->error;
		}
        return $message;
        $stmt->close();
        $mysqli->close();
?>