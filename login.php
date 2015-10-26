<?php
    require_once("functions.php");
    
    //kui kasutaja on sisse logitud, suuna teisele lehele
    //kontrollin kas sessiooni muutuja olemas
    if(isset($_SESSION['logged_in_user_id'])){
        header("Location: data.php");
    }
	
	// muuutujad errorite jaoks
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";
	$create_username_error="";
	

	// muutujad väärtuste jaoks
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";
	$create_username="";

	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
    // *********************
    // **** LOGI SISSE *****
    // *********************
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
				//echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
			
                $hash = hash("sha512", $password);
                
                loginUser($email, $hash);
            
            }
		} // login if end
		
		
    // *********************
    // ** LOO KASUTAJA *****
    // *********************
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
			if ( empty($_POST["create_username"]) ) {
				$create_username_error = "See väli on kohustuslik";
			}else{
				$create_username = cleanInput($_POST["create_username"]);
			}
			
			if(	$create_email_error == "" && $create_password_error == "" && $create_username_error == ""){
				//echo hash("sha512", $create_password);
                //echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password;
                
                // tekitan parooliräsi
                $hash = hash("sha512", $create_password);
                
                //functions.php's funktsioon
                createUser($create_email, $hash);
                
                
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
<?php
	//lehe name
	$page_title="Login leht";
	
	//faili name
	$page_file_name="login.php";
?>

<?php require_once ("header.php"); ?>

  <h2>Log in</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
  	<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Log in">
  </form>

  <h2>Create user</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?>	<br><br>
	<input name="create_username" type="text" placeholder="Kasutajanimi"> <?php echo $create_username_error; ?>	<br><br>
  	<input type="submit" name="create" value="Create user">
  </form>
  

<?php require_once ("footer.php"); ?>