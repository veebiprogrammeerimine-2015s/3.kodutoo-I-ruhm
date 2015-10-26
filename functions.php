<?php
    //loome AB ühenduse
    require_once("../../config_global.php");
    $database = "if15_joosjoe";
	//paneme sessiooni serverist tööle
	session_start();
    
    function createUser($email, $hash, $First_name, $Last_name, $Address){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt=$mysqli->prepare("INSERT INTO user(email, password,first_name,last_name,address) VALUES (?,?,?,?,?)");
		$stmt->bind_param("sssss", $email, $hash, $First_name, $Last_name, $Address);
		
		if($stmt->execute()){
			loginUser($email, $hash);
		} else {
			$stmt->error;
		}
		
		
		$stmt->close();
		
		
		
	}
    
    function logInUser($email, $hash){
       echo $email." ".$hash;
        // GLOBALS saab kätte kõik muutujad mis kasutusel
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("SELECT id, email FROM user WHERE email=? AND password=?");
        $stmt->bind_param("ss", $email, $hash);
        $stmt->bind_result($id_from_db, $email_from_db);
        $stmt->execute();
        if($stmt->fetch()){			
			//Sessioon, salvestatakse aserveris
			$_SESSION['logged_in_user_id'] = $id_from_db;
			$_SESSION['logged_in_user_email'] = $email_from_db;
			header("Location: home.php");
        }else{
			
            echo "Wrong credentials!";
			
        }
        $stmt->close();
        
        $mysqli->close();
        
    }
    
    
	
	function create_qweet($qweet){
		echo $qweet;
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO qweet (user_id, qwert) VALUES (?,?)");

        $stmt->bind_param("ss",$_SESSION['logged_in_user_id'], $qweet);
		echo $qweet;
		$message = "k";
		if($stmt->execute()){
			$message='Edukalt andmebaasi sisestatud!';
			
			
		}
		$stmt->close();
        
        $mysqli->close();
        
		return $message;
		
		
	}
	
	function getAllData($keyword=""){
        
        if($keyword == ""){
            //ei otsi
            $search = "%%";
        }else{
            //otsime
            $search = "%".$keyword."%";
        }
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, qwert from qweet WHERE deleted IS NULL AND (qwert LIKE ?)");
		$stmt->bind_param("s", $search);
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
	

	
 function deleteQweetData($qwert_id, $user_id){
    
    $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
    
    // uuendan välja deleted, lisan praeguse date'i
    $stmt = $mysqli->prepare("UPDATE qweet SET deleted=NOW() WHERE id=? AND user_id=?");
    $stmt->bind_param("ii", $qwert_id, $user_id);
    $stmt->execute();
    
    // tühjendame aadressirea
    header("Location: table.php");
    
    $stmt->close();
    $mysqli->close();
}	

function updateQweetData($qwert, $qwert_id, $user_id){
    
    $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
    
    // uuendan välja deleted, lisan praeguse date'i
    $stmt = $mysqli->prepare("UPDATE qweet SET qwert=? WHERE id=? AND user_id=?");
    $stmt->bind_param("sii",$qwert, $qwert_id, $user_id);
    $stmt->execute();
    
    // tühjendame aadressirea
    header("Location: table.php");
    
    $stmt->close();
    $mysqli->close();
}	
 ?>