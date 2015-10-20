<?php
    //edit_functions.php
    require_once("../../config_global.php");
    $database = "if15_karl";
	
	function getSingleCarData($id){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("SELECT carmodel, mileage, cost, description FROM car_costs WHERE id=? AND deleted IS NULL");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($carmodel, $mileage, $cost, $description);
        $stmt->execute();
        
        // auto objekt
        $car = new StdClass();
		
		// kas sain rea andmeid
        if($stmt->fetch()){
            
            $car->carmodel = $carmodel;
            $car->mileage = $mileage;
            $car->cost = $cost;
			$car->description = $description;
        }else{
            // ei tulnud 
            // kui id ei olnud (vale id)
            // või on kustutatud (deleted ei ole null)
            header("Location: table.php");
        }
        
        $stmt->close();
        $mysqli->close();
        
        return $car;
        
    }
    
    function updateCarData($car_id, $carmodel, $mileage, $cost, $description){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("UPDATE car_costs SET carmodel=?, mileage=?, cost=?, description=? WHERE id=?");
        $stmt->bind_param("sifsi", $carmodel, $milage, $cost, $description, $car_id);
        $stmt->execute();
        
        // tühjendame aadressirea
        header("Location: table.php");
        
        $stmt->close();
        $mysqli->close();
        
    }
    
    
?>