<?php
    // k�ik mis seotud andmetabeliga, lisamine ja tabeli kujul esitamine
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
    
    
    // muutujad v��rtustega
    $homework = $date = $m = "";
    $homework_error = $date_error = "";
    //echo $_SESSION['logged_in_user_id'];
    
    // valideerida v�lja ja k�ivita fn
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if(isset($_POST["add_homework"])){

            if ( empty($_POST["homework"]) ) {
                $homework_error = "Ei saa mitte midagi lisada.";
            }else{
                $homework = cleanInput($_POST["homework"]);
            }
            
            if ( empty($_POST["date"]) ) {
                $date_error = "Kuup�ev puudu!";
            }else{
                $date_cost = cleanInput($_POST["date"]);
            }
			
			
            //erroreid ei olnud k�ivitan funktsiooni,
            //mis sisestab andmebaasi
            if($homework_error == "" && $date_error == ""){
                // m on message mille saadame functions.php
                $m = newHomeworkData($homework, $date);
                            
                if($m != ""){
                    // teeme vormi t�hjaks
                    $homework = "";
                    $date = "";
					
                }
            }
            
        }
    }
    
?>

Tere, <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1">Logi v�lja</a>

<h2>Lisa uus kodut��</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <label for="homework">Kodut�� sisu</label>
  	<input id="homework" name="homework" type="text" value="<?=$homework;?>"> <?=$homework_error;?><br><br>
  	<label for="date"> Esitamise kuup�ev </label>
    <input id="date" name="date" type="text" value="<?=$date;?>"> <?=$date_error;?><br><br>
  	<input type="submit" name="add_homework" value="Lisa">
  </form>