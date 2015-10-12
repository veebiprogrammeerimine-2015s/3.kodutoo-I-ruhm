<?php
	
	require_once("../../config.php");
	$database = "if15_naaber";
	
	session_start();
	
	function loginUser($email, $hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email FROM users_naaber WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		
		if($stmt->fetch()){
			echo "Kasutaja logis sisse id=".$id_from_db;
			$_SESSION['logged_in_user_id'] = $id_from_db;
            $_SESSION['logged_in_user_email'] = $email_from_db;
			header("Location: data.php");
		}else{
			echo "Wrong credentials!";
		}
        $stmt->close();
        $mysqli->close();
	}
	
	function createUser($create_user_email, $hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli ->prepare("INSERT INTO users_naaber (first_name, last_name, organisation, email, password) VALUES (?,?,?,?,?)");
		$stmt->bind_param ("sssss", $first_name, $last_name, $organisation, $create_user_email, $hash);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();
	}

?>