<?php

//loome AB ühenduse
   require_once("../config_global.php");
   $database = "if15_merit26_1";
  
  session_start();
  
      function logInUser($email, $hash){
        
        // GLOBALS saab kätte kõik muutujad mis kasutusel
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
        
        // kui õnnestub siis tõene kui viga siis else
        if($stmt->execute()){
            // õnnestus
            $message = "Edukalt andmebaasi salvestatud!";
        }
        
        $stmt->close();
        $mysqli->close();
        
        // saadan sõnumi tagasi
        return $message;
        
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
    		   $stmt->bind_param("ss", $search, $search);
			   $stmt -> bind_result($training_id_from_db, $user_id_from_db, $begin_from_db, $ending_from_db, $sports_from_db, $distance_from_db);
			   $stmt->execute();
				// massiiv, kus hoiame trenne
				$array = array();
				
				
				
				while($stmt->fetch()){
					//saime andmed kätte
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
             $stmt = $mysqli->prepare("UPDATE training SET deleted=NOW() WHERE training_id=?");
			 $stmt -> bind_param("i", $training_id);
			 $stmt->execute();
			 // tühjendame aadressirea
			 header("Location: table.php");
             $stmt->close(); 
		     $mysqli->close();
	}
   function updateTrainingData($training_id, $begin, $ending, $sports, $distance) {			 
            
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