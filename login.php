<?php
  require_once("functions.php");
	
	//variables
	$email = "";
	$password = "";
	
	//errors
	$email_error = "";
	$password_error = "";
	
	//login start
	
	if( $_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["login"])){
			if (empty($_POST["email"])) {
				$email_error = "E-posti lahter ei tohi olla tühi!";
			} else {
        // puhastame muutuja võimalikest üleliigsetest sümbolitest
				$email = cleanInput($_POST["email"]);
			}
			if (empty($_POST["password"])) {
				$password_error = "Parooli lahter ei tohi olla tühi!";
			} else {
				$password = cleanInput($_POST["password"]);
			}
      // Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$email;
			
                $hash = hash("sha512", $password);
                
                loginUser($email, $hash);
            
            }
		}
	}
	
	//login end
	


	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>