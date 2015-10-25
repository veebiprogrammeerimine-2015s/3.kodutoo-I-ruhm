<?php
    require_once("../config_global.php");
    $database = "if15_raiklep";
	
	
	
	
	session_start();
	
	    function logInUser($email, $hash){
        
        // GLOBALS saab kätte kõik muutujad mis kasutusel
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("SELECT id, email FROM evo_users WHERE email=? AND password=?");
        $stmt->bind_param("ss", $email, $hash);
        $stmt->bind_result($id_from_db, $email_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            echo "Kasutaja logis sisse id=".$id_from_db;
            
            // sessioon, salvestatakse serveris
            $_SESSION['logged_in_user_id'] = $id_from_db;
            $_SESSION['logged_in_user_email'] = $email_from_db;
            
            //suuname kasutaja teisele lehel
            header("Location: data.php");
            
        }else{
            echo "Wrong credentials!";
        }
        $stmt->close();
        
        $mysqli->close();
        
    }
    
    
    function createUser($create_email, $hash){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO evo_users (email, password, created) VALUES (?,?,NOW())");
        $stmt->bind_param("ss", $create_email, $hash);
        $stmt->execute();
        $stmt->close();
        
        $mysqli->close();
        
    }
	
	function newGlasses($prillivarv_from_db, $materjal_from_db) {
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO evo_glasses (user_id, prillivarv, materjal, created) VALUES (?,?,?,NOW())");
        $stmt->bind_param("iss", $_SESSION['logged_in_user_id'], $prillivarv_from_db, $materjal_from_db);
		$message = "";
		if($stmt->execute()) {
			$message = "Edukalt andmebaasi salvestatud";
		}
		
        $stmt->close();
        
        $mysqli->close();
        
		return $message;
    }

	
    function getAllData(){
          
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        // deleted IS NULL - ei ole kustutatud
        $stmt = $mysqli->prepare("SELECT id, user_id, prillivarv, materjal FROM evo_glasses");
        $stmt->bind_result($id_from_db, $user_id_from_db, $prillivarv_from_db, $materjal_from_db);
        $stmt->execute();
        // massiiv kus hoiame autosid
        $array = array();
        
        // iga rea kohta mis on ab'is teeme midagi
        while($stmt->fetch()){
            //suvaline muutuja, kus hoiame auto andmeid 
            //selle hetkeni kui lisame massiivi
               
            // tühi objekt kus hoiame väärtusi
            $evo_glasses = new StdClass();
            
            $evo_glasses->id = $id_from_db;
            $evo_glasses->prillivarv = $prillivarv_from_db; 
            $evo_glasses->user_id = $user_id_from_db; 
            $evo_glasses->materjal = $materjal_from_db; 
            
            //lisan massiivi (auto lisan massiivi)
            array_push($array, $evo_glasses);
            //echo "<pre>";
            //var_dump($array);
            //echo "</pre>";
        }
        
        //saadan tagasi
        return $array;
        
        $stmt->close();
        $mysqli->close();
    }
    
    function deleteCarData($user_id){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        // uuendan välja deleted, lisan praeguse date'i
        $stmt = $mysqli->prepare("UPDATE evo_glasses SET deleted=NOW() WHERE id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        
        // tühjendame aadressirea
        header("Location: table.php");
        
        $stmt->close();
        $mysqli->close();
        
    }
    
    function updateCarData($user_id, $prillivarv, $materjal){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("UPDATE evo_glasses SET prillivarv=?, materjal=? WHERE id=?");
        $stmt->bind_param("ssi", $prillivarv, $materjal, $user_id);
        $stmt->execute();
        
        // tühjendame aadressirea
        header("Location: table.php");
        
        $stmt->close();
        $mysqli->close();
        
    }
    
    
 ?>