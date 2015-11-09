<?php
	
	
    //loome AB ühenduse
    require_once("./functions.php");
    
    //check connection
   


  // muuutujad errorite jaoks
	$username_error = "";
	$email_error = "";
	$password_error = "";
	$create_username_error = "";
	$create_email_error = "";
	$create_password_error = "";
	$confirm_password_error = "";

  // muutujad väärtuste jaoks
	$username = "";
	$email = "";
	$password = "";
	$create_username = "";
	$create_email = "";
	$create_password = "";
	$confirm_password = "";


	if($_SERVER["REQUEST_METHOD"] == "POST") {

    // *********************
    // **** LOGI SISSE *****
    // *********************
		if(isset($_POST["login"])){

			if ( empty($_POST["username"]) ) {
				$username_error = "See väli on kohustuslik";
			}else{
				$username = cleanInput($_POST["username"]);
			}

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
			if($username_error == "" && $password_error == "" && $email_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$username.", email on ".$email." ja parool on ".$password;
			
                $hash = hash("sha512", $password);
                
                loginUser ($username, $email, $hash);
				
				
                
            
            
            }

		} // login if end

    // *********************
    // ** LOO KASUTAJA *****
    // *********************
    if(isset($_POST["create"])){

			if ( empty($_POST["create_username"]) ) {
				$create_username_error = "See väli on kohustuslik";
			}else{
				$create_username = cleanInput($_POST["create_username"]);
			}

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
			
			if ( empty($_POST["confirm_password"]) ) {
				$confirm_password_error = "See väli on kohustuslik";
			} else {
				$confirm_password = cleanInput($_POST["confirm_password"]);
				if($confirm_password != $create_password){
					$confirm_password_error = "Paroolid ei ühti.";
				}
				
			}

			if($create_username_error =="" && $create_email_error == "" && $create_password_error == "" && $confirm_password_error == ""){
				echo hash("sha512", $create_password);
                echo "Võib kasutajat luua! Kasutajanimi on ".$create_username.", email on ".$create_email." ja parool on ".$create_password;
                
                // tekitan parooliräsi
                $hash = hash("sha512", $create_password);
                
                //salvestan andmebaasi
                
                createUser ($create_username, $create_email, $hash);
                
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
   
  

  
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>

  <h2>Log in</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="username" type="username" placeholder="Username" value="<?php echo $username; ?>"> <?php echo $username_error; ?><br><br>
	<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
  	<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Log in">
  </form>

  <h2>Create user</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_username" type="username" placeholder="Username" value="<?php echo $create_username; ?>"> <?php echo $create_username_error; ?><br><br>
	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
	<input name="confirm_password" type="password" placeholder="Kinnita parool"> <?php echo $confirm_password_error; ?> <br><br>
  	<input type="submit" name="create" value="Create user">
  </form>
<body>
<html>
