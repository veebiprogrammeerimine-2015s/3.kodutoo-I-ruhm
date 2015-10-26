<?php
    //loome AB ühenduse
    require_once("../../../configglobal.php");
    $database = "if15_karl";
    //paneme Sessiooni tööle ja saame kasutada SESSION[]
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
			
			$_SESSION['logged_in_user_id'] = $id_from_db;
			$_SESSION['logged_in_user_email'] = $email;
			//suuname kasutaja teisele lehele
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
	
	function createCarPlate ($carmodel, $mileage, $cost, $description){
	
	
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("INSERT INTO car_costs (user_id, carmodel, mileage, cost, description) VALUES (?,?,?,?,?)");
		echo $mysqli->error;
        $stmt->bind_param("siis", $_SESSION['logged_in_user_id'], $carmodel, $mileage, $cost, $description);
	$message = "";
	if($stmt->execute()){
	//worked
	$message = "edukalt andmebaasi salvestatud";
	}
        $stmt->close();
        $mysqli->close();
		return $message;
	
	}
	
	function getAllData(){
		
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("SELECT id, user_id, number_plate, color FROM car_plates");
		$stmt->bind_result($id_from_db, $user_id_from_db, $number_plate_from_db, $color_from_db);
		$stmt->execute();
		//iga hea kohta andmebaasis teeme midagi
        while($stmt->fetch()){
            //saime andmed kätte
			echo ($user_id_from_db);
        }
        $stmt->close();
        $mysqli->close();
	}
 ?>