<?php
$page_title = "login";
$page_file_name = "login.php";

require_once("functions.php");

	
function cleanInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
 }
  
//Errorid & muutujad
	$email = "";
	$password = "";
	$email_error = "";
	$password_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {

if(isset($_POST["login"])){

	if ( empty($_POST["email"]) ) {
		$email_error = "See väli on kohustuslik";
	}else{
		$email = cleanInput($_POST["email"]);
	}
	if ( empty($_POST["password"]) ) {
		$password_error = "See väli on kohustuslik";
	}else{
		$password = cleanInput($_POST["password"]);
	}
	if($password_error == "" && $email_error == ""){
		$password_hash = hash("sha512", $password);
		loginUser($email, $password_hash);
	}

} 
}
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
	<body>
<html>