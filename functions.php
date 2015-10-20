<?php


	require_once("../../config_global.php");
	$database = "if15_karl";
	
	function getAllData($keyword=""){
		
		if($keyword == ""){
			$search = "%%";
		}else{
			$search = "%".$keyword."%";
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        // deleted IS NULL - ei ole kustutatud
        $stmt = $mysqli->prepare("SELECT id, user_id, carmodel, mileage, cost, description FROM car_costs WHERE deleted IS NULL AND (mileage LIKE ? OR carmodel LIKE ? OR description like ? OR cost LIKE ?)");
        $stmt->bind_param("ss", $search, $search);
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
	
	function updateCarData($car_id, $number_plate, $color){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("UPDATE car_costs SET carmodel=?, mileage=? ,cost=?, description=? WHERE id=?");
        $stmt->bind_param("sifs", $carmodel, $mileage, $cost, $description, $car_id);
        $stmt->execute();
        
        // tühjendame aadressirea
        header("Location: table.php");
        
        $stmt->close();
        $mysqli->close();
        
    }
?>