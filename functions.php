<?php

//loome AB ühenduse
   require_once("../config_global.php");
   $database = "if15_merit26_1";
 
  function getAllData($keyword=""){
	  if($keyword== ""){
		  //ei otsi
		 $search = "%%"; 
	  } else {
		 	// otsime	 
		  $search = "%".$keyword."%";
	  }
				 			 
   			 $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);  
			   
			   $stmt = $mysqli->prepare("SELECT training_id, user_id, begin, end, sports, distance FROM training WHERE deleted IS NULL AND (sports LIKE ? OR distance LIKE ?)");
    		   $stmt->bind_param("ss", $search, $search);
			   $stmt -> bind_result($training_id_from_db, $user_id_from_db, $sports_from_db, $distance_from_db);
			   $stmt->execute();
				// massiiv, kus hoiame autosid
				$array = array();
				
				
				
				while($stmt->fetch()){
					//saime andmed kätte
					//andmed saada transporditavale kujule
					
					// suvaline muutuja, kus hoiame auto andmeid massiivi lisamiseni
					$training = new StdClass();
				    $training-> training_id = $training_id_from_db;
					$training-> user_id = $user_id_from_db; 
					$training-> sports = $sports_from_db;
				    $training-> distance = $distance_from_db;
					
					//lisan massiivi
					array_push($array, $training);
					
				}
				return $array;	
				   
					
	          $stmt->close(); 
		      $mysqli->close();      
		   } 
		   
  function deleteTrainingData($training_id){
	  
	 	     $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);  		
             $stmt = $mysqli->prepare("UPDATE training SET deleted=NOW() WHERE training_id=?");
			 $stmt -> bind_param("i", $training_training_id);
			 $stmt->execute();
			 // tühjendame aadressirea
			 header("Location: table.php");
             $stmt->close(); 
		     $mysqli->close();
	}
   function updateCarData($training_training_id, $sports, $distance) {			 
            
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]); 
   
             $stmt = $mysqli->prepare("UPDATE training SET sports=?, distance=? WHERE id=?");
			 $stmt -> bind_param("ssi", $sports, $distance, $training_training_id);
			 $stmt->execute();
			 // tühjendame aadressirea
			 header("Location:table.php");
			 
             $stmt->close(); 
		     $mysqli->close();
     }   
	 
	 
?>