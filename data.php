<?php
    // kõik mis seotud andmetabeliga, lisamine ja tabeli kujul esitamine
    require_once("functions.php");
    
    //kui kasutaja ei ole sisse logitud, suuna teisele lehele
    //kontrollin kas sessiooni muutuja olemas
    if(!isset($_SESSION['id'])){
        header("Location: login.php");
    }
    
    // aadressireale tekkis ?logout=1
    if(isset($_GET["logout"])){
        //kustutame sessiooni muutujad
        session_destroy();
        header("Location: login.php");
    }
	
	function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
    
    
    // muutujad väärtustega
    $homework = $date = $m = "";
    $homework_error = $date_error = "";
    //echo $_SESSION['logged_in_user_id'];
    
    // valideerida välja ja käivita fn
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if(isset($_POST["add_homework"])){

            if ( empty($_POST["homework"]) ) {
                $homework_error = "Ei saa mitte midagi lisada.";
            }else{
                $homework = cleanInput($_POST["homework"]);
            }
            
            if ( empty($_POST["date"]) ) {
                $date_error = "Kuupäev puudu!";
            }else{
                $date_cost = cleanInput($_POST["date"]);
            }
			
			
            //erroreid ei olnud käivitan funktsiooni,
            //mis sisestab andmebaasi
            if($homework_error == "" && $date_error == ""){
                // m on message mille saadame functions.php
                $m = newHomeworkData($homework, $date);
                            
                if($m != ""){
                    // teeme vormi tühjaks
                    $homework = "";
                    $date = "";
					
                }
            }
            
        }
    }
    
?>

Tere, <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1">Logi välja</a>

<h2>Lisa uus kodutöö</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <label for="homework">Kodutöö sisu</label>
  	<input id="homework" name="homework" type="text" value="<?=$homework;?>"> <?=$homework_error;?><br><br>
  	<label for="date"> Esitamise kuupäev </label>
    <input id="date" name="date" type="text" value="<?=$date;?>"> <?=$date_error;?><br><br>
  	<input type="submit" name="add_homework" value="Lisa">
  </form>