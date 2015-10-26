<?php
    require_once("functions.php"); 
	
	if(isset($_SESSION['logged_in_user_id'])){
        header("Location: table.php");
		}
		
	// muuutujad errorite jaoks
	$email_error = "" ;
	$password_error = "" ;
	
	$email_2_error = "" ;
	$password_2_error = "" ;
	$age_error = "" ;
	$gender_error = "" ;
	
      //Muutujad väärtuste jaoks
	 $email = "";
	 $password = "";
	 $email_2 = "";
	 $password_2 = "";
	 $age = "";
	 $gender = "";
	 
	// kontrolli ainult siis, kui kasutaja vajutab "logi sisse" nuppu
	    if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		//kontrollin kas muutuja $_POST["login"] ehk kas inimene tahab sisse logida
		if(isset($_POST["login"])){
			
			//kontrollime, et e-post ei oleks tühi		
			if(empty($_POST["email"])) { 
				$email_error = "Ei saa olla tühi";
			} else {
				//annan väärtuse
				$email = cleaninput($_POST["email"]);
			}
		
			//kontrollime parooli	
			if(empty($_POST["password"])) { 
				 $password_error = "Ei saa olla tühi";
			} else { 
			      $password = cleaninput($_POST["password"]);
			}
		  
			if($password_error == "" && $email_error == ""){
				echo "Sisselogimine. Kasutajanimi on ".$email." ja parool on ".$password;
			   
				$hash = hash("sha512", $password);	
                logInUser($email, $hash);
            
            }
		}
		
			
		 if(isset($_POST["create"])) {
		
			if(empty($_POST["email_2"])) { 
				$email_2_error = "Ei saa olla täitmata";
			} else {
				  $email_2 = cleanInput($_POST["email_2"]);
				
			}
			
			if(empty($_POST["password_2"])) { 
				$password_2_error = "Ei saa olla täitmata";
		    } else {
				if(strlen($_POST["password_2"]) < 8) {
					$password_2_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$password_2 = cleanInput($_POST["password_2"]);
				}
			}
					
			if(empty($_POST["age"])) { 
				$age_error = "Ei saa olla tühi";
			} else {
				$age = cleanInput($_POST["age"]);
			}
			
			if(empty($_POST["gender"])) { 
				$gender_error = "Ei saa olla tühi";
			} else {
				$gender = cleanInput($_POST["gender"]);
			
			}
			
			
			if(	$email_2_error == "" && $password_2_error == "" && $age_error == "" && $gender_error == ""){
				//echo hash("sha512", $password_2);
				echo "Kasutaja loomine. Nüüd võid sisse logida ja trenne kirja panna.";
				//Kasutajanimi on ".$email_2." ja parool on ".$password_2.". Vanus on ".$age.". Sugu on ".$gender.".";
			
				$hash = hash("sha512", $password_2);
			
			
				createUser($email_2, $hash, $age, $gender);	
				
				$email_2= $hash= $age= $gender="";
					
			}
			
		}
			
	}	
     
	
		
	function cleanInput($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
	}
	
?>
<?php
 //lehe nimi
 $page_title = "Login leht";
 // faili nimi
 $page_file_name = "login.php"

?>
<?php require_once("header.php"); ?>
	
		<h2>Log in</h2>

	     <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
			<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
			<input name="password" type="password" placeholder="parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>	
			<input type="submit" name="login" value="Log in">
		</form>
		
		<h2>Create user</h2>
	        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" >
			<input name="email_2" type="email" placeholder="E-post" value="<?php echo $email_2; ?>"> <?php echo $email_2_error; ?><br><br>
			<input name="password_2" type="password" placeholder="parool"> <?php echo $password_2_error; ?> <br><br>
			<input name="age" type="text" placeholder="vanus" value="<?php echo $age; ?>"> <?php echo $age_error; ?> <br><br>
			<input name="gender" type="text" placeholder="sugu mees/naine" value="<?php echo $gender; ?>"> <?php echo $gender_error; ?> <br><br>
			<input type="submit" name="create" value="Create user"> 
		</form>	
		<body>
<html>
		
		
<?php
		//laeme footer.php faili sisu
		require_once("footer.php"); 
?>
		