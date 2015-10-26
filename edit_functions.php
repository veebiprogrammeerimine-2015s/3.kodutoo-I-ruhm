<?php

  require_once("../config_global.php");
   $database = "if15_merit26_1";
   
   function getSingleTrainingData($training_id){
	   
	   $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	   
	   $stmt = $mysqli->prepare("SELECT begin, ending, sports, distance FROM training WHERE training_id=? AND deleted IS NULL");
	   $stmt ->bind_param("i", $id);
	   $stmt ->bind_result($begin, $ending, $sports, $distance);
       $stmt->execute();
	   
	   //trenni objekt
	   $training = new StdClass();
	   
	   
   //kas sain andmed
   if($stmt->fetch()){
	   
	     $training->begin = $begin;
		 $training->ending = $ending;
	     $training->sports = $sports;
		 $training->distance = $distance;
		
   }else{
	   	//ei tulnud kui id ei olnud 
	   header("Location: table.php");
  
	   
	   
   }   
   
   $stmt->close(); 
   $mysqli->close();
   
   return $training;
   
   }
function updateTrainingData($training_training_id, $begin, $ending, $sports, $distance) {			 
            
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]); 
   
             $stmt = $mysqli->prepare("UPDATE training SET begin=?, ending=?, sports=?, distance=? WHERE training_id=?");
			 $stmt -> bind_param("ssssi", $begin, $ending, $sports, $distance, $training_id);
			 $stmt->execute();
			 // tühjendame aadressirea
			 header("Location:table.php");
             $stmt->close(); 
		     $mysqli->close();
     }   
?> 