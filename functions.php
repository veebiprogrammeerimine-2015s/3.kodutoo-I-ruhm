<?php
    //loome AB ühenduse
    require_once("../config_global.php");
    $database = "if15_joosjoe";
	//paneme sessiooni serverist tööle
	session_start();
    
    
    function logInUser($email, $hash){
        
        // GLOBALS saab kätte kõik muutujad mis kasutusel
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
        $stmt->bind_param("ss", $email, $hash);
        $stmt->bind_result($id_from_db, $email_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            echo "Kasutaja logis sisse id=".$id_from_db;
			
			//Sessioon, salvestatakse aserveris
			$_SESSION['logged_in_user_id'] = $id_from_db;
			$_SESSION['logged_in_user_email'] = $email_from_db;
			header("Location: login.php");
        }else{
			
            echo "Wrong credentials!";
			
        }
        $stmt->close();
        
        $mysqli->close();
        
    }
    
    
    function createUser($create_email, $hash){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");
        $stmt->bind_param("ss", $create_email, $hash);
        $stmt->execute();
        $stmt->close();
        
        $mysqli->close();
        
    }
	
	function create_qweet($qwert){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO qweet (user_id, qwert) VALUES (?,?)");

        $stmt->bind_param("is",$_SESSION['logged_in_user_id'], $qwert);
		
		$message = "";
		
			if($stmt->execute()){
				$message = "Edukalt andmebaasi sisestatud!";
			}
		$stmt->close();
        
        $mysqli->close();
        
		return $message;
		
		
	}
	
	function getAllData(){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, qwert from qweet");
		$stmt->bind_result($id_from_db, $user_id_from_db, $qwert_from_db);
		$stmt->execute();
		$array = array();
		while($stmt->fetch()){
			
			$tex = new StdClass();
			$tex->id = $id_from_db;
			$tex->user_id = $user_id_from_db;
			$tex->qwert = $qwert_from_db;
			array_push($array, $tex);
			
			}
			
		return $array;
		
	
	}
	
 function deleteQweetData($tex_id){
    
    $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
    
    // uuendan välja deleted, lisan praeguse date'i
    $stmt = $mysqli->prepare("UPDATE qweet SET deleted=NOW() WHERE id=?");
    $stmt->bind_param("i", $qwert_id);
    $stmt->execute();
    
    // tühjendame aadressirea
    header("Location: table.php");
    
    $stmt->close();
    $mysqli->close();
}	

function updateQweetData($tex_id){
    
    $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
    
    // uuendan välja deleted, lisan praeguse date'i
    $stmt = $mysqli->prepare("UPDATE qweet SET qwert=? WHERE id=?");
    $stmt->bind_param("si",$qwert, $qwert_id);
    $stmt->execute();
    
    // tühjendame aadressirea
    header("Location: table.php");
    
    $stmt->close();
    $mysqli->close();
}	
 ?>