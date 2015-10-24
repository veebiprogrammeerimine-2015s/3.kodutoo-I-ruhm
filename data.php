<?php
	require_once("functions.php");
	
	
	if(!isset($_SESSION['logged_in_user_id'])){
		header("Location: table.php");
	}
	
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php"); 
	}
	
	$m = "";
	
	$gps_point = $location = $habitat_name = $habitat_code = $date_added = "";
	$gps_point_error = $location_error = $habitat_code_error = $habitat_name_error = "";
	

	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		if(isset($_POST["add_habitat"])){
		
		if ( empty($_POST["gps_point"]) ) {
				$gps_point_error = "GPS punkti märkimine on kohustuslik!";
			}else{
				$gps_point = cleanInput($_POST["gps_point"]);
			}	
		if ( empty($_POST["location"]) ) {
				$location_error = "Asukoha märkimine on kohustuslik!";
			}else{
				$location = cleanInput($_POST["location"]);
			}	
		if ( empty($_POST["habitat_name"]) ) {
				$habitat_name_error = "Elupaiga nimetus on kohustuslik!";
			}else{
				$habitat_name = cleanInput($_POST["habitat_name"]);
			}	
		if ( empty($_POST["habitat_code"]) ) {
				$habitat_code_error = "Elupaiga kood on kohustuslik!";
			}else{
				$habitat_code = cleanInput($_POST["habitat_code"]);
			}	
			
	}
	
	
	if($gps_point_error == "" && $location_error =="" && $habitat_name_error =="" && $habitat_code_error =="" ){
		
		$m = createHabitat($gps_point, $location, $habitat_name, $habitat_code);
		
		if($m != ""){
			
			$gps_point = "";
			$location = "";
			$habitat_name = "";			
			$habitat_code = "";
			}
		}
	}
	
	

	
	function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
  
  
  getAllData();
  
	
  
?>

Tere Tulemast, <?=$_SESSION['logged_in_user_email'];?>, siin lehel saad lisada elupaikade andmeid tabelisse! <br>

<br><a href="table.php">VAATA ANDMETABELIT</a>

<h2>Lisa uus elupaik</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <label for="gps_point"> GPS punkt </label>
  	<input id="gps_point" name="gps_point" placeholder="nt. 210 (GPS seadmest)" type="text" value="<?=$gps_point;?>"> <?=$gps_point_error;?><br><br>
	<label for="location"> Asukoht </label>
    <input id="location" name="location" placeholder="nt. Harilaid, Saaremaa" type="text" value="<?=$location;?>"> <?=$location_error;?><br><br>
	<label for="habitat_name"> Elupaiga nimetus </label>
    <input id="habitat_name" name="habitat_name" placeholder="nt. Valge luide" type="text" value="<?=$habitat_name;?>"> <?=$habitat_name_error;?><br><br>
	<label for="habitat_code"> Elupaiga kodeering </label>
    <input id="habitat_code" name="habitat_code" placeholder="nt. 2120" type="text" value="<?=$habitat_code;?>"> <?=$habitat_code_error;?><br><br>
	<input type="submit" name="add_habitat" value="Lisa">
	<p style="color:green;"><?=$m;?></p>
  </form>

  <br><a href="?logout=1">Logi välja!</a><br>