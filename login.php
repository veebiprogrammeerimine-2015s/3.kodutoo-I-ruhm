<?php
$page_title = "login";
$page_file_name = "login.php";
require_once("functions.php");
require_once("header.php");
	
function cleanInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
 }
  
  // muuutujad errorite jaoks
	$email_error = "";
	$password_error = "";
  // muutujad väärtuste jaoks
	$email = "";
	$password = "";
	if($_SERVER["REQUEST_METHOD"] == "POST") {
    //LOGIB SISSE
		if(isset($_POST["login"])){
			if ( empty($_POST["email"]) ) {
				$email_error = "* Ei tohi jääda tühjaks";
			}else{
        // puhastame muutuja võimalikest üleliigsetest sümbolitest
				$email = cleanInput($_POST["email"]);
			}
			if ( empty($_POST["password"]) ) {
				$password_error = "* Ei tohi jääda tühjaks";
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

  <h2>Logi sisse</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
  	<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Logi sisse">
  </form>
<body>
<html>
