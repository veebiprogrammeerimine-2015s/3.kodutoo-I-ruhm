<?php
    require_once("functions.php");
		require_once("../config_global.php");
	
	//Kui kasutaja ei ole sisse logitud, suuna teisele lehele
	//Kontrollin kas sessiooni muutuja on olemas
	
	if(!isset($_SESSION['logged_in_user_id'])) {
		header("Location: register.php");
	}
	
	if($_SESSION['logged_in_user_group'] == 1) {
		header("Location: noaccess.php");
	}

	
    // muutujad väärtustega
    $car_plate = $color = "";
    $car_plate_error = $color_error = "";
		$m = "";
    
    // valideerida välja ja käivita fn
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if(isset($_POST["add_car_plate"])){
            
            if ( empty($_POST["car_plate"]) ) {
                $car_plate_error = "Auto nr on kohustuslik!";
            }else{
                $car_plate = cleanInput($_POST["car_plate"]);
            }
            
            if ( empty($_POST["color"]) ) {
                $color_error = "Auto värv on kohustuslik!";
            }else{
                $color = cleanInput($_POST["color"]);
            }
            
            //erroreid ei olnud käivitan funktsiooni,
            //mis sisestab andmebaasi
            if($car_plate_error == "" && $color_error == ""){
				// $m on message, mille saadame functions.php failist
                $m = createCarPlate($car_plate, $color);
				
				if ($m != "") {
					// Vorm tyhjaks
					$car_plate = "";
					$color = "";
				}
            }
            
        }
    }
    
    
    // kirjuta fn 

	//Küsime tabeli kujul andmed
	getAllData();
	
?>

<?php
	//Lehe nimi
	$page_title = "data";
	//Faili nimi
	$page_file = "data.php";
?>

<?php require_once("header.php"); ?>

<h2>Lisa uus</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <label for="car_plate"> Auto nr </label>
  	<input id="car_plate" name="car_plate" type="text" value="<?=$car_plate;?>"> <?=$car_plate_error;?><br><br>
  	<label for="color"> Värv </label>
    <input id="color" name="color" type="text" value="<?=$color;?>"> <?=$color_error;?><br><br>
  	<input type="submit" name="add_car_plate" value="Lisa">
	<p style="color: green;"><?=$m;?></p>
  </form>