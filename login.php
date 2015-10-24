<?php

	// ühenduse loomiseks kasuta MYSQL
	require_once("functions.php");

	//check connection_aborted
	if(isset($_SESSION['logged_in_user_id'])){
		header("Location: table.php");
	}
	

	
	$email_error = "";
	$password_error ="";
	$password1 = ""; 
	$password1_error ="";
	$name_error = "";
	$surname_error = "";
	$newemail_error = "";
	
	
	//muutujad väärtustega
	$email = "";
	$password = "";
	$name = "";
	$surname = "";
	$newemail = "";
	$dob = "";
	$comment ="";
	$gender = "";
	
	//isset - ütleb kas asi on olemas
	//empty - kas on tühi
	
	//kontrolli ainult siis kui kasutaja vajutab "Logi sisse" nuppu. kas toimub nupuvajutus.
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		if(isset($_POST["login"])){
			
			if(empty($_POST["email"])){
				$email_error = "Sisesta e-mail";
			}else{
				//annan väärtuse
				$email = test_input($_POST["email"]);
			}
		
	
			if(empty($_POST["password"])){
				$password_error = "Sisesta parool!";
			}else{
				$password = test_input($_POST["password"]);
				
				if(strlen($_POST["password"]) <= 8){
					$password_error ="Parool peab olema vähemalt 8 sümbolit pikk!";
				}else{
					$password = test_input($_POST["password"]);
				}
			}
			
			//kui erroreid pole, siis viskab veebilehe päisesse sisestatud andmed
			
				if($email_error == "" && $password_error == ""){
					// kui erroreid ei olnud
					echo "Võib sisse logida!";
				
					$hash = hash("sha512", $password);
					
					logInUser($email, $hash);
				
					
				}
		}
			
		
	
	//siit algab kasutaja loomise osa.
	
		
		if(isset($_POST["createuser"])){ //kui vajutatakse "registreeri kasutaja" nuppu
		
			if (empty($_POST["name"])) {
				$name_error = "Eesnime väli on kohustuslik!";
			}else{
				$name = test_input($_POST["name"]);
			}	
		
			if (empty($_POST["surname"])) {
				$surname_error = "Perekonnanime väli on kohustuslik!";
			}else{
				$surname = test_input($_POST["surname"]);
			}	
		
			if(empty($_POST["newemail"])){
				$newemail_error = "e-maili väli on kohustuslik!";
			}else{
				$newemail = test_input($_POST["newemail"]);
			}
		
			if(empty($_POST["password1"])){
				$password1_error="Ei saa olla tühi";
			}else{
            
				//parool ei ole tĆ¼hi, kontrollime pikkust
				if(strlen($_POST["password1"]) < 8){
					$password1_error="Peab olema vĆ¤hemalt 8 sümbolit!";
				}else{
					$password1 = test_input($_POST["password1"]);
                
				//errorit trükitakse HTML osas rea järel php koodis.
				}
				
			}
			
			if(!empty($_POST["comment"])){
				$comment = test_input($_POST["comment"]);
			}
			
			if(!empty($_POST["dob"])){
				$dob = test_input($_POST["dob"]);
			}
			
			
			if(!empty($_POST["gender"])){
				$gender = test_input($_POST["gender"]);
			}
		
		
		if($name_error == "" && $surname_error == "" && $newemail_error == "" && $password1_error == ""){
					// kui erroreid ei olnud
					
				
				echo "KASUTAJA LOODUD!";
					
				$hash = hash("sha512", $password1);
				
				createUser($name, $surname, $newemail, $hash, $comment, $dob, $gender);
				
				}
		
		}
	
	
	}
	//Selle saan lisada igale asjale, et käiks läbi ja kustutaks üleliigse.
	function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data); //kaotab liigsed kaldkriipsud
	$data = htmlspecialchars($data); //võtab erinevad HTML sümbolid ja teeb teksti kujule.
	return $data;
		}
	
?>
<?php
	//lehe nimi
	$page_title = "Logi sisse!";
	
	//faili nimi
	$page_file_name = "login.php";
?>
<!DOCTYPE html>

<html>
<head>
		<title><p>Veebileht kujutaks endast pigem informatiivset lehte avalikkusele, kuhu on koondatud geoökoloogia välitöödel saadud info/andmed. See on töödeldud selliseks, et ka tavainimene saaks aru.
		Tegemist Natura 2000 rannikuelupaikade projektiga. Leht hõlmab kirjeldusi, pilte, graafikuid, skeeme jne.
		</title>
</head>
<body>
		
	
	
		<h2>Log in</h2>
		<!--selleks, et -->
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			
				<input name="email" type="email" placeholder="e-post" value="<?php echo $email;?>" >* <?php echo $email_error; ?> <br><br>
				<input name="password" type="password" placeholder="parool">* <?php echo $password_error; ?><br><br>
				<input name="login" type="submit" value="Logi sisse">
			
			</form>
			
			
		<h2>Create user</h2>
			
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			
				<input type="text" name="name" placeholder="Eesnimi" value="<?php echo $name;?>" >* <?php echo $name_error;?><br><br>
				<input type="text" name="surname" placeholder="Perekonnanimi" value="<?php echo $surname;?>" >* <?php echo $surname_error;?><br><br>
				<input name="newemail" type="email" placeholder="e-post" value="<?php echo $newemail;?>" >* <?php echo $newemail_error; ?> <br><br>
				<input name="password1" type="password" placeholder="Sisesta soovitud parool">* <?php echo $password1_error; ?><br><br>
				
				
				
				Biograafia <textarea name="comment" rows="5" cols="30"><?php echo $comment;?></textarea><br>
				
				<p>Sünniaeg: <input type="text" name="dob" placeholder="nt. 01.01.1993" /></p>
				
				<input type="radio" name="gender" value="female" <?php if (isset($gender) && $gender=="female") echo "checked";?>>Naine
				<input type="radio" name="gender" value="male" <?php if (isset($gender) && $gender=="male") echo "checked";?>>Mees <br><br>
				<input name="createuser" type="submit" value="Registreeri kasutajaks!">
			
			
			</form>
					
			
		
	</body>
	</html>