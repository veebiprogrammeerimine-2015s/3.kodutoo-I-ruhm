<?php
	/*  
    // config_global.php
    $servername = "";
    $server_username = "";
    $server_password = "";
    */
	
	//db ühendus
	require_once("../config_global.php");
	$database = "if15_kelllep";
	
	session_start();
	
	function logInUser($email, $username, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, username, email FROM user_db WHERE email=? AND password=?");
        $stmt->bind_param("ss", $email, $hash);
        $stmt->bind_result($id_from_db, $username_from_db, $email_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            echo "Kasutaja logis sisse id=".$id_from_db;
			
			// sessioon, salvestatakse serveris
            $_SESSION['logged_in_user_id'] = $id_from_db;
			$_SESSION['logged_in_user_username'] = $username_from_db;
            $_SESSION['logged_in_user_email'] = $email_from_db;
			            
			//suuname kasutaja teisele lehel
            header("Location: data.php");
			
                }else{
                    echo "Vale e-mail või parool!";
                }
                
                $stmt->close();
				//echo $stmt->error;
                //echo $mysqli->error;
		
	}
	
	function createUser($new_email, $hash, $new_username){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_db (email, password, username) VALUES (?,?,?)");
		$stmt->bind_param("sss", $new_email, $hash, $new_username);
		$stmt->execute();
		$stmt->close();
                
        $mysqli->close();
            
		
	}
	
	function createNewPost($postitus) {
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO postitus (user_id, user_username, postitus) VALUES (?,?,?)");
        // i - on user_id INT
        $stmt->bind_param("iss", $_SESSION['logged_in_user_id'], $_SESSION['logged_in_user_username'], $postitus);
        
        $message = "";
        
        // kui õnnestub siis tõene kui viga siis else
        if($stmt->execute()){
            // õnnestus
            $message = "Postitus edukalt sisestatud!";
        }
        
        $stmt->close();
        $mysqli->close();
        
        // saadan sõnumi tagasi
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
        // deleted IS NULL - ei ole kustutatud
        $stmt = $mysqli->prepare("SELECT id, user_id, user_username, postitus FROM postitus WHERE deleted IS NULL AND user_username LIKE ? OR deleted IS NULL AND postitus LIKE ?");
        $stmt->bind_param("ss", $search, $search);
		$stmt->bind_result($id_from_db, $user_id_from_db, $user_username_from_db, $postitus_from_db);
        $stmt->execute();
        // massiiv kus hoiame autosid
        $array = array();
        
        // iga rea kohta mis on ab'is teeme midagi
        while($stmt->fetch()){
            //suvaline muutuja, kus hoiame auto andmeid 
            //selle hetkeni kui lisame massiivi
               
            // tühi objekt kus hoiame väärtusi
            $post = new StdClass();
            
            $post->id = $id_from_db;
            $post->postitus = $postitus_from_db; 
            $post->user_id = $user_id_from_db; 
			$post->user_username = $user_username_from_db;
            
            array_push($array, $post);
            //echo "<pre>";
            //var_dump($array);
            //echo "</pre>";
        }
        
        //saadan tagasi
        return $array;
        
        $stmt->close();
        $mysqli->close();
    }
    
    function deletePostData($user_id){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        // uuendan välja deleted, lisan praeguse date'i
        $stmt = $mysqli->prepare("UPDATE postitus SET deleted=NOW() WHERE id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        
        // tühjendame aadressirea
        header("Location: table.php");
        
        $stmt->close();
        $mysqli->close();
        
    }
    
    function updatePostData($user_id, $postitus){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("UPDATE postitus SET postitus=? WHERE id=?");
        $stmt->bind_param("si", $postitus, $user_id);
        $stmt->execute();
        
        // tühjendame aadressirea
        header("Location: table.php");
        
        $stmt->close();
        $mysqli->close();
        
    }
    
    
?>
