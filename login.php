<?php
    require_once("functions.php");
    require_once("../config.php");
    $database = "if15_richaas_1";

    $mysqli = new mysqli($servername, $username, $password, $database);

    // Kui _SESSION olemas suuna teisele lehele
    if(isset($_SESSION['logged_in_user_id'])){
        header("Location: data.php");
    }


  // Muutujad väärtuste ja errorite jaoks
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";

	$email = "";
	$user_password = "";
	$create_email = "";
	$create_password = "";


  // Kui tehakse POST request (vajutatakse logi sisse / registreeru nuppu)
	if($_SERVER["REQUEST_METHOD"] == "POST") {

    // **** LOGI SISSE *****

		if(isset($_POST["login"])){

			if ( empty($_POST["email"]) ) {
				$email_error = "See väli on kohustuslik";
			}else{
        // cleanInput() puhastab sisendit, turvalisuse eesmärgil
				$email = cleanInput($_POST["email"]);
			}

			if ( empty($_POST["user_password"]) ) {
				$password_error = "See väli on kohustuslik";
			}else{
				$user_password = cleanInput($_POST["user_password"]);
			}

      // Sisselogimine
			if($password_error == "" && $email_error == ""){

                $hash = hash("sha512", $user_password);

                loginUser($email, $hash);

      }
		}

    // ** LOO KASUTAJA *****

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
                // tekitan parooliräsi
                $hash = hash("sha512", $create_password);

                //functions.php's funktsioon
                createUser($create_email, $hash);
            }
        }
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
  	<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
  	<input name="user_password" type="password" placeholder="Parool" value="<?php echo $user_password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Log in">
  </form>

  <h2>Create user</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
  	<input type="submit" name="create" value="Create user">
  </form>
</body>
</html>
