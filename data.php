<?php
    require_once("functions.php");
	
	//Kui kasutaja ei ole sisse logitud, suuna teisele lehele
	//Kontrollin kas sessiooni muutuja on olemas
	
	if(!isset($_SESSION['logged_in_user_id'])) {
		header("Location: login.php");
	}

	//aadressireale tekkis ?logout=1
	if(isset($_GET["logout"])) {
		//kustutame sessiooni muutujad
		session_destroy();
		header("Location: login.php");
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
    function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
	
	//Küsime tabeli kujul andmed
	getAllData();
	
?>

Tere, <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1">Logi välja</a>

<h2>Lisa uus</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <label for="car_plate"> Auto nr </label>
  	<input id="car_plate" name="car_plate" type="text" value="<?=$car_plate;?>"> <?=$car_plate_error;?><br><br>
  	<label for="color"> Värv </label>
    <input id="color" name="color" type="text" value="<?=$color;?>"> <?=$color_error;?><br><br>
  	<input type="submit" name="add_car_plate" value="Lisa">
	<p style="color: green;"><?=$m;?></p>
  </form>