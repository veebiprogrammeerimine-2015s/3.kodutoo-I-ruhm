<?php
//lehe nimi
$page_title = "Login";
//faili nimi
$page_file_name = "login.php";
?>
<?php require_once("../header.php"); ?>
<?php


	// loome andmebaasi ühenduse
	require_once("../../../config.php");
	$database = "if15_karl";
	$mysqli = new mysqli ($servername, $username, $password, $database);
	
	//check connection
	if($mysqli->connect_error) {
		die("connect error".mysqli_connect_error());
	}


  // muuutujad errorite jaoks
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";

  // muutujad väärtuste jaoks
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";


	if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Login sisse
		if(isset($_POST["login"])){

			if ( empty($_POST["email"]) ) {
				$email_error = "See väli on kohustuslik";
			}else{
        // puhastame muutuja võimalikest üleliigsetest sümbolitest
				$email = cleanInput($_POST["email"]);
			}

			if ( empty($_POST["password"]) ) {
				$password_error = "See väli on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}

      // Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
			
				$hash = hash("sha512", $password);
				
				$stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
				
				//küsimärkide asendus
				$stmt->bind_param ("ss", $email, $hash);
				//andmebaasist tulnud andmete muutujad
				$stmt->bind_result($id_from_db, $email_from_db);
				$stmt->execute();
				
				if($stmt->fetch()) {
					
					//kasutaja email ja parool õiged
					echo " kasutaja logis sisse, ID on".$id_from_db;
				}else{
					echo "Wrong credentials!";
				}				
				$stmt->close();
			
			}

		} // login if end

    // kasutaja loomine
    if(isset($_POST["create"])){

			if ( empty($_POST["create_email"]) ) {
				$create_email_error = "See väli on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
			}

			if ( empty($_POST["create_password"]) ) {
				$create_password_error = "See väli on kohustuslik";
			} else {
				if(strlen($_POST["create_password"]) < 8) {
					$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$create_password = cleanInput($_POST["create_password"]);
				}
			}

			if(	$create_email_error == "" && $create_password_error == ""){
				echo hash("sha512", $create_password);
				echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password;
				
				//tekitan parooli räsi
				$hash = hash("sha512", $create_password);
				
				//salvestan andmebaasi
				$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES(?,?)");
				
				//paneme muutujad küsimärkide asemele
				//ss - s string, iga muutuja kohta 1 täht
				$stmt-> bind_param("ss", $create_email, $hash);
				
				//käivitab sisestuse
				$stmt->execute();
				$stmt->close();
	  
	  }

    } // create if end

	}

  // funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }

  //Close connection
  $mysqli->close();
  
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>

  <h2>Log in</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
  	<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Log in">
  </form>

  <h2>Create user</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
  	<input type="submit" name="create" value="Create user">
  </form>
<body>
<html>
<?php require_once("../footer.php"); ?>