<?php
    //edit_functions.php
    require_once("../config_global.php");
    $database = "if15_raiklep";
    
    function getSingleGlassData($id){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("SELECT prillivarv, materjal FROM evo_glasses WHERE id=? AND deleted IS NULL");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($prillivarv, $materjal);
        $stmt->execute();
        
        // auto objekt
        $car = new StdClass();
        
        // kas sain rea andmeid
        if($stmt->fetch()){
            
            $car->prillivarv = $prillivarv;
            $car->materjal = $materjal;
            
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
    
    function updateGlassData($user_id, $prillivarv, $materjal){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("UPDATE evo_glasses SET prillivarv=?, materjal=? WHERE id=?");
        $stmt->bind_param("ssi", $number_plate, $color, $car_id);
        $stmt->execute();
        
        // tühjendame aadressirea
        header("Location: table.php");
        
        $stmt->close();
        $mysqli->close();
        
    }
    
    
?>