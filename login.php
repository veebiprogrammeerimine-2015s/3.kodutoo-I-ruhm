<?php
    require_once("functions.php");
    
    if(isset($_SESSION['logged_in_user_username'])){
        header("Location: data.php");
    }


  // muuutujad errorite jaoks
	$user_id_error = "";
	$username_error = "";
	$firstname_error = "";
	$lastname_error = "";
	$phone_error = "";
	$email_error = "";
	$password_error = "";
	$create_user_id_error = "";
	$create_username_error = "";
	$create_firstname_error = "";
	$create_lastname_error = "";
	$create_phone_error = "";
	$create_email_error = "";
	$create_password_error = "";

  // muutujad väärtuste jaoks
	$user_id = "";
	$username = "";
	$firstname = "";
	$lastname = "";
	$phone = "";
	$email = "";
	$password = "";
	$create_user_id = "";
	$create_username = "";
	$create_firstname = "";
	$create_lastname = "";
	$create_phone = "";
	$create_email = "";
	$create_password = "";


	if($_SERVER["REQUEST_METHOD"] == "POST") {

    // sisse logimine
		if(isset($_POST["login"])){

			if ( empty($_POST["username"]) ) {
				$username_error = "See väli on kohustuslik";
			}else{
				$username = cleanInput($_POST["username"]);
			}

			if ( empty($_POST["password"]) ) {
				$password_error = "See väli on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}

			if($password_error == "" && $username_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$username." ja parool on ".$password."";
			
                $hash = hash("sha512", $password);
                
                loginUser($username, $hash);
            
            }

		}

    // kasutaja loomine
	
    if(isset($_POST["create"])){
		
			if ( empty($_POST["create_username"]) ) {
				$create_username_error = "See väli on kohustuslik";
			}else{
				$create_username = cleanInput($_POST["create_username"]);
			}
	
			if ( empty($_POST["create_firstname"]) ) {
				$create_firstname_error = "See väli on kohustuslik";
			}else{
				$create_firstname = cleanInput($_POST["create_firstname"]);
			}

			if ( empty($_POST["create_lastname"]) ) {
				$create_lastname_error = "See väli on kohustuslik";
			}else{
				$create_lastname = cleanInput($_POST["create_lastname"]);
			}

			if ( empty($_POST["create_phone"]) ) {
				$create_phone_error = "See väli on kohustuslik";
			}else{
				$create_phone = cleanInput($_POST["create_phone"]);
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

			if(	$create_username_error == "" && $create_password_error == ""){
				//echo hash("sha512", $create_password);
                echo "Võib kasutajat luua! Kasutajanimi on ".$create_username." ja parool on ".$create_password;
                
                // tekitan parooliräsi
                $hash = hash("sha512", $create_password);
                
                //functions.php's funktsioon
                createUser($create_username, $create_firstname, $create_lastname, $create_phone, $create_email, $hash);
                
                
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
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>

  <h2>Log in</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="username" type="username" placeholder="Username" value="<?php echo $username; ?>"> <?php echo $username_error; ?><br><br>
  	<input name="password" type="password" placeholder="Password" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Log in">
  </form>

  <h2>Create user</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_username" type="username" placeholder="Username" value="<?php echo $create_username; ?>"> <?php $create_username_error; ?><br><br>
	<input name="create_firstname" type="firstname" placeholder="First name" value="<?php echo $create_firstname; ?>"> <?php $create_firstname_error; ?><br><br>
	<input name="create_lastname" type="lastname" placeholder="Last name" value="<?php echo $create_lastname; ?>"> <?php $create_lastname_error; ?><br><br>
	<input name="create_phone" type="phone" placeholder="Mobile" value="<?php echo $create_phone; ?>"> <?php $create_phone_error; ?><br><br>
  	<input name="create_email" type="email" placeholder="E-mail" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Password"> <?php echo $create_password_error; ?> <br><br>
  	<input type="submit" name="create" value="Create user">
  </form>
<body>
<html>
