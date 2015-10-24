<?php 

    require_once("../config_global.php");
    $database = "if15_skmw";
	
	function getAllData($keyword=""){
		
		if($keyword == ""){
			
			$search = "%%";
		
			
		}else{
			$search = "%".$keyword."%";
			
		}
	
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, gps_point, location, habitat_name, habitat_code FROM habitat_data WHERE deleted IS NULL AND (gps_point LIKE ? OR location LIKE ? OR habitat_name LIKE ? OR habitat_code LIKE ?)");
		$stmt->bind_param("ssss", $search, $search, $search, $search);
		$stmt->bind_result($id_from_db, $user_id_from_db, $gps_point_from_db, $location_from_db, $habitat_name_from_db, $habitat_code_from_db);
		$stmt->execute();
		
		$array = array();
		$array = array();
		$array = array();
		$array = array();
	
        while($stmt->fetch()){
			
		   $habitat = new StdClass();
		   
		   $habitat->id = $id_from_db;
		   $habitat->user_id = $user_id_from_db;
		   $habitat->gps_point = $gps_point_from_db;
		   $habitat->location = $location_from_db;
		   $habitat->habitat_name = $habitat_name_from_db;
		   $habitat->habitat_code = $habitat_code_from_db;
		   
		   array_push($array, $habitat);
		  
        }
	
		return $array;

        $stmt->close();
		$mysqli->close();
		
	}
	function deleteHabitat($habitat_id){
		 $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		 
		 $stmt = $mysqli->prepare("UPDATE habitat_data SET deleted=NOW() WHERE id=?");
		 $stmt->bind_param("i", $habitat_id);
		 $stmt->execute();
		
		 header("Location: table.php");
		 
		 $stmt->close();
		 $mysqli->close();
	}

	function updateHabitat($habitat_id, $gps_point, $location, $habitat_name, $habitat_code){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE habitat_data SET gps_point=?, location=?, habitat_name=?, habitat_code=? WHERE id=?");
		$stmt->bind_param("issii", $gps_point, $location, $habitat_name, $habitat_code, $habitat_id);
		$stmt->execute();
		header("Location: table.php");
		$stmt->close();
		$mysqli->close();
	}
    session_start();

	
	function logInUser($email, $hash){
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email FROM users WHERE email=? AND password=?"); 
        $stmt->bind_param("ss", $email, $hash);
        $stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
			if($stmt->fetch()){
                    echo "Kasutaja logis sisse id=".$id_from_db;
					
					$_SESSION['logged_in_user_id'] =  $id_from_db;
					$_SESSION['logged_in_user_email'] =  $email_from_db;

					header("Location: data.php");
					
                }else{
                    echo "Wrong credentials!";
                }
                $stmt->close();
				$mysqli->close();
	}
	
	function createUser($create_email, $hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO users (name, surname, email, password, comment, dob, gender) VALUES (?,?,?,?,?,?,?)");
		$stmt->bind_param("sssssss", $name, $surname, $create_email, $hash, $comment, $dob, $gender);
		$stmt->execute();
        $stmt->close();
		$mysqli->close();	
	}
	
	
	function createHabitat($habitat_plate, $location, $habitat_name, $habitat_code){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO habitat_data (user_id, gps_point, location, habitat_name, habitat_code) VALUES (?,?,?,?,?)");
		echo $mysqli->error;
		$stmt->bind_param("iissi", $_SESSION['logged_in_user_id'], $habitat_plate, $location, $habitat_name, $habitat_code);
		
		$message = "";
		
		if($stmt->execute()){
			
			$message = "Edukalt lisatud andmebaasi!";
		}else{
			
		}
        $stmt->close();
		$mysqli->close();
		
		return $message;
	}
	
	
?>