<?php
	//Lehe nimi
	$page_title = "Avaleht";
	//Faili nimi
	$page_file = "home.php";
?>

<?php
	require_once("functions.php");

	//variables
	$create_email = "";
	$create_password = "";
	
	//errors
	$create_email_error = "";
	$create_password_error = "";

	if( $_SERVER["REQUEST_METHOD"] == "POST") {
	//register start
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
				echo hash("sha512", $create_password);
                echo "Võib kasutajat luua! Kasutajanimi on ".$create_email;
                
                // tekitan parooliräsi
                $hash = hash("sha512", $create_password);
                
                //functions.php's funktsioon
                createUser($create_email, $hash);
                
                
            }
        }
				
	}
//register end

?>
<?php 
	require_once("header.php"); 
	require_once("menu.php");
?>

<h1>Loo konto</h1>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
  	<input type="submit" name="create" value="Create user">
  </form>

	
	