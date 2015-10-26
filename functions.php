<?php

//loome AB �henduse
   require_once("../config_global.php");
   $database = "if15_merit26_1";
  
  session_start();
  
      function logInUser($email, $hash){
        
        // GLOBALS saab k�tte k�ik muutujad mis kasutusel
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("SELECT id, email FROM users WHERE email=? AND password=?");
        $stmt->bind_param("ss", $email, $hash);
        $stmt->bind_result($id_from_db, $email_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            echo "Kasutaja logis sisse id=".$id_from_db;
            
            // sessioon, salvestatakse serveris
            $_SESSION['logged_in_user_id'] = $id_from_db;
            $_SESSION['logged_in_user_email'] = $email_from_db;
            
            //suuname kasutaja teisele lehele
            header("Location: data.php");
            
        }else{
            echo "Wrong credentials!";
        }
        $stmt->close();
        
        $mysqli->close();
        
    }
    
    
    function createUser($email_2, $hash, $age, $gender){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO users (email, password, age, gender) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $email_2, $hash, $age, $gender);
        $stmt->execute();
        $stmt->close();
        
        $mysqli->close();
        
    }
    
    function createTraining($begin, $ending, $sports, $distance) {
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO training (user_id, begin, ending, sports, distance) VALUES (?,?,?,?,?)");
        // i - on user_id INT
        $stmt->bind_param("issss", $_SESSION['logged_in_user_id'], $begin, $ending, $sports, $distance);
        
        $message = "";
        
        // kui �nnestub siis t�ene kui viga siis else
        if($stmt->execute()){
            // �nnestus
            $message = "Edukalt andmebaasi salvestatud!";
			header("Location: table.php");
        }
        
        $stmt->close();
        $mysqli->close();
        
        // saadan s�numi tagasi
        return $message;
        
    }
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
	
  function getAllData($keyword=""){
	  if($keyword== ""){
		  //ei otsi
		 $search = "%%"; 
	  } else {
		 	// otsime	 
		  $search = "%".$keyword."%";
	  }
				 			 
   			   $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);  
			   
			   $stmt = $mysqli->prepare("SELECT training_id, user_id, begin, ending, sports, distance FROM training WHERE deleted IS NULL AND (sports LIKE ? OR distance LIKE ?)");
    		   $stmt->bind_param("ss",  $search, $search);
			   $stmt -> bind_result($training_id_from_db, $user_id_from_db, $begin_from_db, $ending_from_db, $sports_from_db, $distance_from_db);
			   $stmt->execute();
				// massiiv, kus hoiame trenne
				$array = array();
				
				
				
				while($stmt->fetch()){
					//saime andmed k�tte
					//andmed saada transporditavale kujule
					
					// suvaline muutuja, kus hoiame andmeid massiivi lisamiseni
					$training = new StdClass();
				    $training-> training_id = $training_id_from_db;
					$training-> user_id = $user_id_from_db; 
					$training-> begin = $begin_from_db;
				    $training-> ending = $ending_from_db;
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
             $stmt = $mysqli->prepare("UPDATE training SET deleted=NOW() WHERE training_id=? AND user_id=?");
			 $stmt -> bind_param("ii", $training_id, $_SESSION['logged_in_user_id']);
			 $stmt->execute();
			 // t�hjendame aadressirea
			 header("Location: table.php");
             $stmt->close(); 
		     $mysqli->close();
	        }
  function updateTrainingData($training_id, $begin, $ending, $sports, $distance) {			 
            
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]); 
   
             $stmt = $mysqli->prepare("UPDATE training SET begin=?, ending=?, sports=?, distance=? WHERE training_id=? AND user_id=?");
			 $stmt -> bind_param("ssssii", $begin, $ending, $sports, $distance, $training_id, $_SESSION['logged_in_user_id']);
			 $stmt->execute();
			 // t�hjendame aadressirea
			 header("Location:table.php");
			 $stmt->close(); 
		     $mysqli->close();
     }   
	 
	 
?>