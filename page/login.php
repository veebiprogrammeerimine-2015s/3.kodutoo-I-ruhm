<?php

	require_once("functions.php");
    
    if(isset($_SESSION['logged_in_user_id'])){
        header("Location: data.php");
    }

	$email_error = "";
	$password_error = "";

	$email = "";
	$password = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if(isset($_POST["login"])){

            if(empty($_POST["email"])) {
                $email_error = "Ei saa olla tühi";
            } else {
                $email = cleanInput($_POST["email"]);		
            }
            
            if(empty($_POST["password"])) {
                $password_error = "Ei saa olla tühi";
            } else {
                $password = cleanInput($_POST["password"]);
            }
            
            if($password_error == "" && $email_error == ""){
				
				$hash = hash("sha512", $password);
				
				loginUser($email, $hash);
				
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

	$page_title = "Login";
	$page_file = "login.php";
	
?>
<?php require_once("../header.php"); ?>
		<h2>Login</h2>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<input name="email" type="email" placeholder="E-post" value ="<?php echo $email; ?>">* <?php echo $email_error; ?> <br><br>
			<input name="password" type="password" placeholder="Parool">* <?php echo $password_error; ?> <br><br>
			<input name="login" type="submit" value="Logi sisse">
		</form>
<?php require_once("../footer.php"); ?>