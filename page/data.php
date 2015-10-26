<?php
require_once("functions.php");
	
	//kui kasutaja on sisse logitud siis suuna kasutaja edasi
	//kontrollin kas sessiooni muutuja on olemas
	if(!isset($_SESSION['logged_in_user_id'])){
	header("Location: login.php");
	}
	
	if(isset($_GET["logout"])){
		//kustutame sessiooni muutujad
		session_destroy();
		header("Location: login.php");
	}
	$carmodel = $mileage = $cost = $description = $m = "";
	$car_plate_error = $color_error = "";
	$user_id = $_SESSION['logged_in_user_id'];
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_POST["add_car_cost"])){
			
			if (empty($_POST["carmodel"])){
				$car_plate_error = "Auto nr märk on kohustuslik!";
			}else{
				$carmodel = cleanInput($_POST["carmodel"]);
			}
		
			if (empty($_POST["mileage"])){
				$color_error = "Värvus on kohustuslik!";
			}else{
				$mileage = cleanInput($_POST["mileage"]);
			}
			
			 if($car_plate_error == "" && $color_error == ""){
                //createCarPlate($_SESSION['logged_in_user_id'], $carmodel, $mileage);
				$m = createCarPlate($carmodel, $mileage, $cost, $description);
		   if($m !=""){
			$carmodel = "";
			$mileage = "";
		   
		   }
		}
	}
	}
	function cleanInput($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
	//küsime tabeli kujul andmed
	
	getAllData();
	
	
	?>
	
	Tere, <?$_SESSION['logged_in_user_email'])?> <a href="?logout=1">Logi välja</a>
	
	<h2>Lisa uus</h2>
	
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="carmodel">Auto mudel</label>
	<input id="carmodel" name="carmodel" type="text" value="<?= $carmodel; ?>"> <?= $car_plate_error; ?><br><br>
  	<label for="mileage">Läbisõit</label>
	<input id="mileage" name="mileage" type="number" value="<?= $mileage; ?>"> <?= $color_error; ?><br><br>
	<label for="cost">Hind</label>
	<input id="cost" name="cost" type="number" value="<?= $cost; ?>"> <?= $color_error; ?><br><br>
	<label for="description">Kirjeldus</label>
	<input id="description" name="description" type="text" value="<?= $description; ?>"> <?= $color_error; ?><br><br>
  	<input type="submit" name="add_car_cost" value="Lisa">
	<p style="color:green;"><?=$m;?>
	</form>