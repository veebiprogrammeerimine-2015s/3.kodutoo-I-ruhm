<?php
    //edit_functions.php
    require_once("../../config_global.php");
    $database = "if15_karl";
	
	function getSingleCarData($id){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("SELECT carmodel, mileage, cost, description FROM car_plates WHERE id=? AND deleted IS NULL");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($carmodel, $mileage, $cost, $description);
        $stmt->execute();
        
        // auto objekt
        $car = new StdClass();