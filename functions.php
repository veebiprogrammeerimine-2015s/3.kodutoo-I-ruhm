<?php

	$search = 0;
	//loome AB ühenduse
    require_once("../../../configglobal.php");
    $database = "if15_karl";
    //paneme Sessiooni tööle ja saame kasutada SESSION[]
	session_start();
	
	
	function getAllData($keyword=""){
		
		if($keyword == ""){
			$search = "%%";
		}else{
			$search = "%".$keyword."%";
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        // deleted IS NULL - ei ole kustutatud
        
		$stmt = $mysqli->prepare("SELECT id, user_id, carmodel, mileage, cost, description FROM car_costs 
		WHERE deleted IS NULL AND user_id={$_SESSION['logged_in_user_id']} AND (mileage LIKE ? OR carmodel LIKE ? OR description like ? OR cost LIKE ?)");
        
		echo $mysqli->error;
		
		$stmt->bind_param("ssss", $search, $search, $search, $search);
        $stmt->bind_result($id_from_db, $user_id_from_db, $carmodel_from_db, $mileage_from_db, $cost_from_db, $description_from_db);
        $stmt->execute();
	
	
	$array = array();
	
	while($stmt->fetch()){
            //suvaline muutuja, kus hoiame auto andmeid 
            //selle hetkeni kui lisame massiivi
               
            // tühi objekt kus hoiame väärtusi
            $car = new StdClass();
            
            $car->id = $id_from_db;
            $car->user_id = $user_id_from_db; 
			$car->carmodel = $carmodel_from_db;
			$car->mileage = $mileage_from_db;
            $car->cost = $cost_from_db;
			$car->description = $description_from_db;
            
            //lisan massiivi (auto lisan massiivi)
            array_push($array, $car);
            //echo "<pre>";
            //var_dump($array);
            //echo "</pre>";
        }
        
        //saadan tagasi
        return $array;
        
        $stmt->close();
        $mysqli->close();
    }
	
	function deleteCarData($car_id){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        // uuendan välja deleted, lisan praeguse date'i
        $stmt = $mysqli->prepare("UPDATE car_costs SET deleted=NOW() WHERE id=?");
        $stmt->bind_param("i", $car_id);
        $stmt->execute();
        
        // tühjendame aadressirea
        header("Location: table.php");
        
        $stmt->close();
        $mysqli->close();
        
    }
	
    function updateCarData($car_id, $carmodel, $mileage, $cost, $description){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("UPDATE car_costs SET carmodel=?, mileage=? ,cost=?, description=? WHERE id=?");
        $stmt->bind_param("sidsi", $carmodel, $mileage, $cost, $description, $car_id);
        $stmt->execute();
        
        // tühjendame aadressirea
        //header("Location: table.php");
        
        $stmt->close();
        $mysqli->close();
        
    }
	
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
    
    
    function createUser($create_email, $hash, $create_vehicle, $create_location){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, uservehicle, userlocation) VALUES (?,?,?,?)");
		echo $mysqli->error;
        $stmt->bind_param("ssss", $create_email, $hash, $create_vehicle, $create_location);
        $stmt->execute();
        $stmt->close();
        
        $mysqli->close();
        
    }
	
	function createCarPlate ($carmodel, $mileage, $cost, $description){
	
	echo $carmodel, $mileage, $cost, $description;
	
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("INSERT INTO car_costs (user_id, carmodel, mileage, cost, description) VALUES (?,?,?,?,?)");
		echo $mysqli->error;
        $stmt->bind_param("isids", $_SESSION['logged_in_user_id'], $carmodel, $mileage, $cost, $description);
	$message = "";
	if($stmt->execute()){
	//worked
	$message = "edukalt andmebaasi salvestatud";
	}
        $stmt->close();
        $mysqli->close();
		return $message;
	
	}
	
	
	
?>