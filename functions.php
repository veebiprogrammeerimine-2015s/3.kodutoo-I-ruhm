<?php

    require_once("../config_global.php");
    $database = "if15_anniant";
    
    //paneme sessiooni serveris tööle, saaame kasutada SESSION[]
    session_start();
    
    
    function logInUser($email, $hash){
        
        // GLOBALS saab kätte kõik muutujad mis kasutusel
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
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
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");
        $stmt->bind_param("ss", $create_email, $hash);
        $stmt->execute();
        $stmt->close();
        
        $mysqli->close();
        
    }
	
	function createCat($nimi, $vanus, $sugu, $kirjeldus){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO kassid (nimi, vanus, sugu, kirjeldus, kodus) VALUES (?,?,?,?,?)");
		$stmt->bind_param("sisss", $nimi, $vanus, $sugu, $kirjeldus, $kodus);
		
		$message="";
		
		//kui õnnestub siis tõene kui viga siis else
		if ($stmt->execute()){
			//õnnestus
			$message="edukalt andmebaasi salvestatud";
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $message;
	}
	
 
    //vaikeväärtus sulgusdes, et vältida errorit, mis tekiks real 31 table.phps
    function getAllHomeless($keyword=""){
		
		$search="";
		
        if($keyword == ""){
			//ei otsi
			$search="%%";
			
		}else{
			//otsime
			$search="%".$keyword."%";
		}
		
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		
        $stmt = $mysqli->prepare("SELECT id, nimi, vanus, sugu, kirjeldus, kodus FROM kassid WHERE kodus='ei' AND(nimi LIKE ? OR sugu LIKE ?)");
		$stmt->bind_param("ss", $search, $search);
        $stmt->bind_result($id_from_db, $nimi_from_db, $vanus_from_db, $sugu_from_db, $kirjeldus_from_db, $kodus_from_db);
        $stmt->execute();
        
		//massiiv kus hoiame autosid
		$array=array();
		
        // iga rea kohta mis on ab'is teeme midagi
        while($stmt->fetch()){
			//suvaline muutuja kus hoiame andmeid kuni massiivi lisamiseni
			
			//tühi objektkus hoiame väärtusi
			$cat=new StdClass();
			
			$cat->id=$id_from_db;
			$cat->nimi=$nimi_from_db;
			$cat->vanus=$vanus_from_db;
			$cat->sugu=$sugu_from_db;
			$cat->kirjeldus=$kirjeldus_from_db;
			$cat->kodus=$kodus_from_db;
			
			//lisan massiivi
			array_push($array, $cat);
			/*echo "<pre>";
			var_dump($array);
			echo "</pre>";*/
        }
		
		//saadan array tagasi
		return $array;

        
        $stmt->close();
        $mysqli->close();
    }
	
	    //vaikeväärtus sulgusdes, et vältida errorit, mis tekiks real 31 table.phps
    function getAllKodus($keyword=""){
		
		$search="";
		
        if($keyword == ""){
			//ei otsi
			$search="%%";
			
		}else{
			//otsime
			$search="%".$keyword."%";
		}
		
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		
        $stmt = $mysqli->prepare("SELECT id, nimi, vanus, sugu, kirjeldus, kodus FROM kassid WHERE kodus='jah' AND(nimi LIKE ? OR sugu LIKE ?)");
		$stmt->bind_param("ss", $search, $search);
        $stmt->bind_result($id_from_db, $nimi_from_db, $vanus_from_db, $sugu_from_db, $kirjeldus_from_db, $kodus_from_db);
        $stmt->execute();
        
		//massiiv kus hoiame autosid
		$array=array();
		
        // iga rea kohta mis on ab'is teeme midagi
        while($stmt->fetch()){
			//suvaline muutuja kus hoiame andmeid kuni massiivi lisamiseni
			
			//tühi objektkus hoiame väärtusi
			$cat=new StdClass();
			
			$cat->id=$id_from_db;
			$cat->nimi=$nimi_from_db;
			$cat->vanus=$vanus_from_db;
			$cat->sugu=$sugu_from_db;
			$cat->kirjeldus=$kirjeldus_from_db;
			$cat->kodus=$kodus_from_db;
			
			//lisan massiivi
			array_push($array, $cat);
			/*echo "<pre>";
			var_dump($array);
			echo "</pre>";*/
        }
		
		//saadan array tagasi
		return $array;

        
        $stmt->close();
        $mysqli->close();
    }
	
	//vaikeväärtus sulgusdes, et vältida errorit, mis tekiks real 31 table.phps
    function getAllCats($keyword=""){
		
		$search="";
		
        if($keyword == ""){
			//ei otsi
			$search="%%";
			
		}else{
			//otsime
			$search="%".$keyword."%";
		}
		
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		
        $stmt = $mysqli->prepare("SELECT id, nimi, vanus, sugu, kirjeldus, kodus FROM kassid WHERE (nimi LIKE ? OR sugu LIKE ?)");
		$stmt->bind_param("ss", $search, $search);
        $stmt->bind_result($id_from_db, $nimi_from_db, $vanus_from_db, $sugu_from_db, $kirjeldus_from_db, $kodus_from_db);
        $stmt->execute();
        
		//massiiv kus hoiame autosid
		$array=array();
		
        // iga rea kohta mis on ab'is teeme midagi
        while($stmt->fetch()){
			//suvaline muutuja kus hoiame andmeid kuni massiivi lisamiseni
			
			//tühi objektkus hoiame väärtusi
			$cat=new StdClass();
			
			$cat->id=$id_from_db;
			$cat->nimi=$nimi_from_db;
			$cat->vanus=$vanus_from_db;
			$cat->sugu=$sugu_from_db;
			$cat->kirjeldus=$kirjeldus_from_db;
			$cat->kodus=$kodus_from_db;
			
			//lisan massiivi
			array_push($array, $cat);
			/*echo "<pre>";
			var_dump($array); 
			echo "</pre><br><br><br><br><br><br>";*/
        }
		
		//saadan array tagasi
		return $array;

        
        $stmt->close();
        $mysqli->close();
    }
	
	function updateCatData($cat_id, $cat_vanus, $cat_kodus, $cat_kirjeldus){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		
		
        $stmt = $mysqli->prepare("UPDATE kassid SET vanus= ?, kodus='?', kirjeldus='?'  WHERE id=?");
        $stmt->bind_param("issi", $cat_vanus, $cat_kodus, $cat_kirjeldus, $cat_id);
        $stmt->execute();
		
		//tühjendame aadressirea
		//header("Location:table.php");
		
		$stmt->close();
		$mysqli->close();
		
	}
    
    
 ?>