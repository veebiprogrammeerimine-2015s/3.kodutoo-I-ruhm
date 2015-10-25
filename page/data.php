<?php
    //kõik, mis on seotud andmetabelitega, lisamine ja tabeli kujul esitamine
    require_once("functions.php");
    
    //kui kasutaja on sisse logitud, suuna teisele lehele
    //kontrollin, kas sessiooni muutuja on olemas 
    if(!isset($_SESSION['logged_in_user_id'])){
        header("Location: login.php");
    }
    
    //aadressireale tekkis ?logout=1
    if(isset($_GET["logout"])){
        //kustutame sessiooni muutujad
        session_destroy();
        header("Location: login.php");
    }
    
    //muutuja väärtused
    $car_plate = $color = $m = "";
    $car_plate_error = $color_error = "";
    //echo $_SESSION['logged_in_user_id'];
    

     //valideeri väljad
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
            
            //erroreid ei olnud, käivitan funktsiooni, mis sisaldab andmebaasi
            
            if($car_plate_error == "" && $color_error == ""){
                //m on message, mille saadame function.php failist
                $m = createCarPlate($car_plate, $color);
                if($m != ""){
                    //teeme vormi tühjaks
                    $car_plate = "";
                    $color = "";
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

Tere, <?=$_SESSION['logged_in_user_email'];?> <br><a href="?logout=1">Logi välja</a>

<h2>Lisa uus</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <label> Auto nr </label>
  	<input id="car_plate" name="car_plate" type="text"  value="<?=$car_plate;?>"> <?=$car_plate_error; ?><br><br>
    <label> Värv </label>
  	<input id="color" name="color" type="text" value="<?=$color; ?>"> <?=$color_error; ?><br><br>
  	<input type="submit" name="add_car_plate" value="Lisa">
    <p style="color:green;"><?=$m;?></p>
  </form>