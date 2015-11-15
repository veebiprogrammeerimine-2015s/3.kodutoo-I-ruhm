<?php

    require_once("../config_global.php");
    $database = "if15_kristalv";
    
    session_start();
    
    
    function logInUser($username, $hash){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("SELECT username, password FROM notes WHERE username=? AND password=?");
        $stmt->bind_param("ss", $username, $hash);
        $stmt->bind_result($username_from_db, $password_from_db);
        $stmt->execute();

        if($stmt->fetch()){
            echo "Kasutaja logis sisse id=".$username_from_db;
            
            $_SESSION['logged_in_user_username'] = $username_from_db;
            $_SESSION['logged_in_user_password'] = $password_from_db;
            
			header("Location: data.php");
            
        }else{
            echo "";
        }
        $stmt->close();
        
        $mysqli->close();
        
    }
    
    
    function createUser($create_username, $create_firstname, $create_lastname, $create_phone, $create_email, $hash){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);

        $stmt = $mysqli->prepare("INSERT INTO notes (username, firstname, lastname, phone, email, password) VALUES (?,?,?,?,?,?)");
		echo $mysqli->error;
        $stmt->bind_param("ssssss", $create_username, $create_firstname, $create_lastname, $create_phone, $create_email, $hash);
        $stmt->execute();
        
		$stmt->close();
        $mysqli->close();
        
    }

	function createNote($username, $title, $text) {
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO notes (username, title, text, time) VALUES (?,?,?,CURRENT_TIMESTAMP())");

        $stmt->bind_param("sss", $_SESSION['logged_in_user_username'], $title, $text);
        
        $message = "";
        
        if($stmt->execute()){
            $message = "Edukalt salvestatud!";
        }
        
        $stmt->close();
        $mysqli->close();
        
        return $message;
        
    }
	
	    function deleteNote($id){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("UPDATE notes SET deleted='1' WHERE id=? AND username = ?");
        $stmt->bind_param("is", $id, $_SESSION['logged_in_user_username']);
        $stmt->execute();
        
        header("Location: data.php");
        
        $stmt->close();
        $mysqli->close();
        
    }
	
	    function updateNote($id, $username, $title, $text){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("UPDATE notes SET title=?, text=? WHERE id=? AND username = ?");
        $stmt->bind_param("ssis", $title, $text, $id, $_SESSION['logged_in_user_username']);
        $stmt->execute();
        
        header("Location: data.php");
        
        $stmt->close();
        $mysqli->close();
        
    }
	
    function getAllData($keyword=""){
        
		$search = "";
		
		if($keyword == ""){
			$search = "%%";
		}else{
			$search = "%".$keyword."%";
		}
		
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);

        $stmt = $mysqli->prepare("SELECT id, username, title, text, time FROM notes WHERE deleted IS NULL AND title IS NOT NULL AND (title LIKE ? OR text LIKE ?)");
		$stmt->bind_param("ss", $search, $search);
        $stmt->bind_result($id_from_db, $user_id_from_db, $title_from_db, $text_from_db, $time_from_db);
        $stmt->execute();

        $array = array();
        
        while($stmt->fetch()){

            $note = new StdClass();
            
            $note->id = $id_from_db;
            $note->title = $title_from_db; 
            $note->username = $user_id_from_db; 
            $note->text = $text_from_db; 
			$note->time = $time_from_db; 
            
            array_push($array, $note);

        }

        return $array;
        
        $stmt->close();
        $mysqli->close();
    }
?>