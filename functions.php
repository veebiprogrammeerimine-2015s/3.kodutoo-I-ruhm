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
        $stmt = $mysqli->prepare("SELECT id, user_id, car, mileage, cost, description FROM car_costs WHERE deleted IS NULL AND (mileage LIKE ? OR description like ? OR cost LIKE ?)");
        $stmt->bind_param("ss", $search, $search);
        $stmt->bind_result($id_from_db, $user_id_from_db, $car_from_db, $mileage_from_db, $cost_from_db, $description_from_db);
        $stmt->execute();
	}
	
	$array = array();
	
	
?>