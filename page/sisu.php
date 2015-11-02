
<?php
	require_once("../functions.php");
	
	
	
	require_once("../../config.php");
	$database = "if15_joosjoe";
	$mysqli = new mysqli($servername, $username, $password, $database);
	if($mysqli ->connect_error) {
		die("Connect error".mysqli_connect_error() );
	}
	function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
$email_error = "";
$pw_error = "";
$gender_error = "";
$email = "";
// Muutujad väärtustega


	// kontrolli ainult kui vajutatakse submit
	if($_SERVER["REQUEST_METHOD"]  == "POST"){
		//kontrollib kas muutuju $_POST["login"]
		if (isset($_POST["login"]) ){						
	//kontrollime eposti et poleks tühi
	
				if(empty($_POST["email"])){
					$email_error = "Insert e-mail";
				} else {
					$email = cleanInput($_POST["email"]);
				}
				if(empty($_POST["password"])){
					$pw_error = "Insert password";
				}else{
					$password = cleanInput($_POST["password"]);
				}
			}
			if($pw_error == "" && $email_error == ""){
				$hash = hash("sha512", $password);
				loginUser($email, $hash);
			}
		}
$mysqli->close();
?>
<?php 
	$page_title = "Log In";
	$page_file_name = "sisu.php";
	if(isset($_SESSION['logged_in_user_id'])){
		header("Location: data.php");
		
	}
?>

<!--<link rel="stylesheet" href="styles.css">-->

<?php require_once("../header.php");?>
	
	<body>
			<div id="header" >
				<img href="Kass.png"/>
			</div>
			<div class="center2">
			<p style="font-size:30px";>Log In</p>
			<form action="<?php echo $_SERVER["PHP_SELF"]?> " method="post">
			
				<p>Email/Username</p>
				<input name="email" type="email" placeholder="@example.com" value="<?php echo $email;?>" > <?php echo $email_error;?> <br>
				<p>Password</p>
				<input name="password" type="password" placeholder="Password" > <?php echo $pw_error;?>
				<br><br>
				<input name="login" type="submit" value="Log In">
			</form>	
			</div>
<?php require_once("../footer.php"); ?>