<?php 
	$page_title = "create";
	$page_file_name = "create.php";

	require_once("functions.php");
	require_once("header.php");

	
function cleanInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
 }
  
//Errorid ja muutujad on siin
	$create_email_error = "";
	$create_password_error = "";
	$create_username_error = "";
	$email_error = "";
	$password_error = "";
	
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";
	$create_username = "";
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";
	$create_username_error = "";
	

 if(isset($_POST["create"])){

	if ( empty($_POST["create_email"]) ) {
		$create_email_error = "See väli on kohustuslik";
	}else{
		$create_email = cleanInput($_POST["create_email"]);
	}

	if ( empty($_POST["create_password"]) ) {
		$create_password_error = "See v?li on kohustuslik";
	} else {
		if(strlen($_POST["create_password"]) < 8) {
			$create_password_error = "Peab olema v?hemalt 8 t?hem?rki pikk!";
		}else{
			$create_password = cleanInput($_POST["create_password"]);
		}
	if ( empty($_POST["create_username"]) ) {
			$create_username_error = "Tuleb valida endale nimi";
	}else{
			$create_username = cleanInput($_POST["create_username"]);
		}
	}
		if(	$create_email_error == "" && $create_password_error == ""){
			echo "Võib kasutajat luua! Email on ".$create_email." ja parool on ".$create_password;
				
			$password_hash = hash("sha512", $create_password);
			echo "<br>";
			echo $password_hash;
				
			createUser($create_email, $password_hash, $create_username);
		}
 } 
 ?>
<!DOCTYPE html>
<html>
	<h2>Loo uus kasutaja</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
	<input name="create_username" type="text" placeholder="Kasutaja nimi" value="<?php echo $create_username; ?>"> <?php echo $create_username_error; ?><br><br>
  	<input type="submit" name="create" value="Loo kasutaja">
  </form>
<body>
<html>

