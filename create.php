<?php 
$page_title = "create";
$page_file_name = "create.php";
require_once("header.php"); 
require_once("functions.php");

	
function cleanInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
 }
  
//Errorid & muutujad
	$create_email_error = "";
	$create_password_error = "";
	$create_age_error = "";
	$create_email = "";
	$create_age = "";
	

 if(isset($_POST["create"])){

	if ( empty($_POST["create_email"]) ) {
		$create_email_error = "Mandatory";
	}else{
		$create_email = cleanInput($_POST["create_email"]);
	}

	if ( empty($_POST["create_password"]) ) {
		$create_password_error = "Mandatory";
	}else {
		if(strlen($_POST["create_password"]) < 8) {
			$create_password_error = "8 symbols minimum!";
		}else{
			$create_password = cleanInput($_POST["create_password"]);
		}
		
	}
	if ( empty($_POST["create_age"]) ) {
		$create_age_error = "Mandatory";
	}else {
		$create_age = cleanInput($_POST["create_age"]);
	}
	
		if(	$create_email_error == "" && $create_password_error == "" && $create_age_error == ""){	
			$password_hash = hash("sha512", $create_password);
			
			createUser($create_email, $password_hash, $create_age);
		}
 } 
 ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Create</title>
	</head>
	<body>
		<h2>Create user</h2>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
		<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
		<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
		<input name="create_age" type="number" placeholder="Age" value="<?php echo $create_age; ?>"> <?php echo $create_age_error; ?><br><br>
		<input type="submit" name="create" value="Create user">
	</form>
	<body>
<html>