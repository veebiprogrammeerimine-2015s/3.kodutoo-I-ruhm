<?php
    //edit_functions.php

    require_once("../../config_global.php");
    $database = "if15_brenbra_1";
    
    function getSingleHomeworkData($id){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);

        $stmt = $mysqli->prepare("SELECT homework, date FROM homeworks WHERE id=? AND deleted IS NULL");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($homework, $date);
        $stmt->execute();
        
        // auto objekt
        $homework = new StdClass();
        
        // kas sain rea andmeid
        if($stmt->fetch()){
            
            $homework->homework = $homework;
            $homework->date = $date;
            
        }else{
            // ei tulnud 
            // kui id ei olnud (vale id)
            // või on kustutatud (deleted ei ole null)
            header("Location: table.php");
        }
        
        $stmt->close();
        $mysqli->close();
        
        return $homework;
        
    }
	function updateHomeworkData($homework_id, $homework, $date){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("UPDATE homeworks SET homework=?, date=? WHERE id=?");
        $stmt->bind_param("ssi", $homework, $date, $homework_id);
        $stmt->execute();
        
        // tühjendame aadressirea
        header("Location: table.php");
        
        $stmt->close();
        $mysqli->close();
        $mysqli->close();
		
		
        
    }
?>