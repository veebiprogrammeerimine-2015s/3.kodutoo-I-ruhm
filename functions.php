<?php
    //loome AB ühenduse
    require_once("../config_global.php");
    $database = "if15_raunkos";
    
	//paneme sessiooni serveris toole, saame kasutada SESSIOS[]
	session_start();
    
    function logInUser($email, $hash){
        
        // GLOBALS saab kätte kõik muutujad mis kasutusel
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
        $stmt->bind_param("ss", $email, $hash);
        $stmt->bind_result($id_from_db, $email_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            echo "Kasutaja logis sisse id=".$id_from_db;
			
			// sessioon salvestatakse serveris
			$_SESSION['logged_in_user_id'] = $id_from_db;
			$_SESSION['logged_in_user_email'] = $email_from_db;
			//Suuname kasutaja teisele lehele
			header("Location: data.php");
			
        }else{
            echo "Wrong credentials!";
        }
        $stmt->close();
        
        $mysqli->close();
        
    }
    
    
    function createUser($create_email, $hash){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");
        $stmt->bind_param("ss", $create_email, $hash);
        $stmt->execute();
        $stmt->close();
        
        $mysqli->close();
        
    }
	
	
	
    function createCarPlate($plate, $car_color) {
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO car_plates (user_id, number_plate, color) VALUES (?,?,?)");
        // i - on user_id INT
        $stmt->bind_param("iss", $_SESSION['logged_in_user_id'], $plate, $car_color);
        
		$message = "";
		//Kui onnestub ss toene kui viga ss else
		if($stmt->execute()) {
			//onnestus
			$message = "Edukalt andmebaasi salvestatud";
		}
		
        $stmt->close();
        
        $mysqli->close();
        
		return $message;
    }
	
	
	function getAllData() {
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, number_plate, color FROM car_plates");
		$stmt->bind_result($id_from_db, $user_from_db, $number_plate_from_db, $color_from_db);
		//Iga rea kohta teeme midagi
		while($stmt->fetch()) {
			//Saime andmed katte
			echo($user_id_from_db);
			
		}
	$stmt->close();
	$mysqli->close();
	}

	
	
	
	
 ?>