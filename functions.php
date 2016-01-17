<?php

    require_once("../../config_global.php");
    $database = "if15_brenbra_1";
	session_start();
    function getAllData($keyword=""){
		
		if($keyword == ""){
            //ei otsi
            $search = "%%";
        }else{
            //otsime
            $search = "%".$keyword."%";
        }
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);

        $stmt = $mysqli->prepare("SELECT id, user_id, homework, date FROM homeworks where homework LIKE ?");
		$stmt->bind_param("s", $search);
        $stmt->bind_result($id_from_db, $user_id_from_db, $homework_from_db, $date_from_db);
        $stmt->execute();
        
        // massiiv kus hoiame autosid
        $array = array();
        
        // iga rea kohta mis on ab'is teeme midagi
        while($stmt->fetch()){
            //suvaline muutuja, kus hoiame auto andmeid 
            //selle hetkeni kui lisame massiivi
               
            // t�hi objekt kus hoiame v��rtusi
            $homework = new StdClass();
            
            $homework->id = $id_from_db;
            $homework->homework = $homework_from_db;
			$homework->user = $user_id_from_db;
			$homework->date = $date_from_db;
            
            //lisan massiivi (auto lisan massiivi)
            array_push($array, $homework);
            //echo "<pre>";
            //var_dump($array);
            //echo "</pre>";
        }
        
        //saadan tagasi
        return $array;
			
        
        
        $stmt->close();
        $mysqli->close();
    }
	
	function deleteHomeworkData($id){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        // uuendan v�lja deleted, lisan praeguse date'i
        $stmt = $mysqli->prepare("UPDATE homeworks SET deleted=NOW() WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // t�hjendame aadressirea
        header("Location: table.php");
        
        $stmt->close();
	}
	
	function newHomeworkData($homework, $date){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("INSERT INTO homeworks(homework, date, deleted) VALUES(?,?,NULL)");
        $stmt->bind_param("ss",$homework, $date);
        $stmt->execute();
        
        // t�hjendame aadressirea
        header("Location: table.php");
        
        $stmt->close();
        $mysqli->close();
        $mysqli->close();
		
		
        
    }
    function loginUser ($username, $email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE username=? AND email=? AND password=?");
                // k�sim�rkide asendus
                $stmt->bind_param("sss", $username, $email, $hash);
                //ab tulnud muutujad
                $stmt->bind_result($id_from_db, $email_from_db);
                $stmt->execute();
                
                // teeb p�ringu ja kui on t�ene (st et ab oli see v��rtus)
                if($stmt->fetch()){
                    
                    // Kasutaja email ja parool �iged
                    echo "Kasutaja logis sisse id=".$id_from_db;
					$_SESSION["email"] = $email_from_db;
					$_SESSION["id"] = $id_from_db;
					
					
                    header("Location: table.php");
                }else{
                    echo "Wrong credentials!";
                }
                
                $stmt->close();
	}
	function createUser ($create_username, $create_email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (username, email, password) VALUES (?,?,?)");
                
                //kirjutan v�lja error
                //echo $stmt->error;
                //echo $mysqli->error;
                
                // paneme muutujad k�sim�rkide asemel
                // ss - s string, iga muutuja koht 1 t�ht
                $stmt->bind_param("sss",$create_username, $create_email, $hash);
                
                //k�ivitab sisestuse
                $stmt->execute();
                $stmt->close();
	}
    
 ?>