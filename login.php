<?php
//ANDMEBAASID

    //AB YHENDUS
    require_once("../config_global.php");
    $database = "if15_raunkos";
    $mysqli = new mysqli($servername, $server_username, $server_password, $database);
	
	//Yhenduse kontrollimine
    if($mysqli->connect_error) {
        die("connect error ".mysqli_connect_error());
    }


?>
<?php
//PAGE TITLE
	//Lehe nimi
	$page_title = "UCP";
	//Faili nimi
	$page_file = "login.php";
?>
<?php 
// LOGIMINE JA REGISTREERUMINE
	/* user_form.php
	Jutumarkide vahele input elemendi NAME
	
	echo $_POST["email"];
	echo $_POST["password"];*/

	//Kontrolli ss kui kasutaja vajutab submit

	//Logimise errorid
	$email_error = "";
	$password_error = "";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//isset uurib kas muutuja on loodud ning ega poleks olematu/kehtetu
		//Uurib, mis nuppu on vajutatud, antul juhul logi sissem $_POST["login"]
		if (isset($_POST["btnlogin"])) {
		//Kontrolli kasutaja e-posti ja parooli, et see poleks tühi
			if (empty($_POST["email"])) {
				$email_error = "Palun sisesta e-posti aadress!";
			
			} else {
				$email = test_input($_POST["email"]);
			}
			if (empty($_POST["password"])) {
				$password_error = "Palun sisesta parool!";
			
			} else {
				$password = test_input($_POST["password"]);
				
			}
			
			if($password_error == "" && $email_error == "") {
				echo "Kontrollin ".$email." ".$password;
			}
			
			//Kasutaja sisselogimine, kui vigu 0
			
			if($password_error == "" && $email_error == ""){
				echo "Sisse logimine! Kasutajanimi on ".$email." ja parool on ".$password;
				
				$hash = hash("sha512", $password);
				
				$stmt = $mysqli->prepare("SELECT id, email FROM ntb_andmed WHERE email=? AND password=? ");
				//kysimarkide asendus
				//echo $mysqli->error;
				$stmt->bind_param("ss", $email, $hash);
				//andmebaasist tulnud muutujad
				$stmt->bind_result($id_from_db, $email_from_db);
				$stmt->execute();
				//teeb paringu ja kui on toene (st et ab oli see vaartus)
				if($stmt->fetch()) {
					
					echo "kasutaja logis sisse, id=".$id_from_db;
					
				} else {
					
					echo "Kasutajanimi või parool vale";
				}
			}
		}
	}
	
	//LOGIMISE LOPP
	
	
	//Registreerumise errorid
	$reg_email_error = "";
	$reg_password_error = "";
	$reg_password_repeat_error = "";
	$reg_name_error = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["btnregister"])) {
			//Kontrolli kasutaja e-posti ja parooli, et see poleks tühi
			if (empty($_POST["reg_email"])) {
				$reg_email_error = "Palun sisesta e-posti aadress!";
			} else {
				$reg_email = test_input($_POST["reg_email"]);
			}
			if (empty($_POST["reg_name"])) {
				$reg_name_error = "Palun sisesta enda nimi!";
			} else {
				$reg_name = test_input($_POST["reg_name"]);
			}
		
			if (empty($_POST["reg_password"])) {
				$reg_password_error = "Palun sisesta parool!";
				
			} elseif (strlen($_POST["reg_password"]) < 8) {
			$reg_password_error = $reg_password_error. "Teie parool on alla 8 tähemärgi!";
				
				
			} else {
				$reg_password = test_input($_POST["reg_password"]);
			}
			if (empty($_POST["reg_password_repeat"])) {
			$reg_password_repeat_error = "Teie parool ei kattunud eelneva parooliga!";
				
			} else {
				$reg_password_repeat = test_input($_POST["reg_password_repeat"]);
			}
			
			if(	$reg_email_error == "" && $reg_password_error == ""){
				echo hash("sha512", $reg_password);
				echo "Loome kasutaja! Kasutajanimi on ".$reg_email.", teie nimi on".$reg_name." ja parool on ".$reg_password;
				
				// tekitan parooliräsi
				$hash = hash("sha512", $reg_password);
				
				//salvestan andmebaasi
				$stmt = $mysqli->prepare("INSERT INTO ntb_andmed (email, name, password) VALUES (?,?,?)");
				
				//kirjutan valja errori
				//echo $stmt->error();
				
				// paneme muutujad küsimärkide asemel
				// ss - s string, iga muutuja koht 1 täht
				$stmt->bind_param("sss", $reg_email, $reg_name, $hash);
				
				//käivitab sisestuse
				$stmt->execute();
				$stmt->close();
                
                
            }
		}
	} 
	
	//Reg Errorid lõpp
	
	//Muutujad väärtustega
	
	$email = "";
	
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
}
	
?>
<?php require_once("header.php"); ?>
				<div id="login">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<h2>Logi sisse</h2>
						<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
						<input name="password" type="password" placeholder="Parool"> <?php echo $password_error; ?><br><br>
						
						<input type="submit" name="btnlogin" value="Logi sisse">
					</form>
				</div>

				<div id="register">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<h2>Registreeru</h2>
						<input name="reg_email" type="email" placeholder="E-post" value="<?php echo $email; ?>">* <?php echo $reg_email_error; ?><br><br>
						<input name="reg_name" type="text" placeholder="Teie nimi">* <?php echo $reg_name_error; ?><br><br>						
						<input name="reg_password" type="password" placeholder="Parool">* <?php echo $reg_password_error;?><br><br>
						<input name="reg_password_repeat" type="password" placeholder="Korda parooli">* <?php echo $reg_password_repeat_error; ?><br><br>
						
						<input type="submit" name="btnregister" value="Registreeru">
					</form>
				</div>

<?php require_once("footer.php"); ?>