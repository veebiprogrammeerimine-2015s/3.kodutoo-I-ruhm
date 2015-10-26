<?php
   // kõik mis seotud andmetabeliga, lisamine ja tabeli kujul esitamine
   require_once("functions.php");
   // kui kasutaja on sisse logitud, suuname teisele lehele
   // kontrolin, kas sessioonimuutja on olemas
   
   if(!isset($_SESSION['logged_in_user_id'])){
	   header("Location: login.php");
   }
   
   if(isset($_GET["logout"])){
	   
	   session_destroy();
	   header("Location: login.php");
   }
   
   // muutujad väärtustega
   $training=$begin=$ending=$sports=$distance=$m="";
   $training_error=$begin_error=$ending_error=$sports_error=$distance_error="";
   
   // valideerida väljad
   if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["add_training"])){

			if( empty($_POST["begin"]) ) {
				$begin_error = "See väli on kohustuslik";
			}else{
        // puhastame muutuja võimalikest üleliigsetest sümbolitest
				$begin = cleanInput($_POST["begin"]);
			}

			if ( empty($_POST["ending"]) ) {
				$ending_error = "See väli on kohustuslik";
			}else{
				$ending = cleanInput($_POST["ending"]);
			}
			
			if( empty($_POST["sports"]) ) {
				$sports_error = "See väli on kohustuslik";
			}else{
        // puhastame muutuja võimalikest üleliigsetest sümbolitest
				$sports = cleanInput($_POST["sports"]);
			}

			if ( empty($_POST["distance"]) ) {
				$distance_error = "See väli on kohustuslik";
			}else{
				$distance = cleanInput($_POST["distance"]);
			}
			// kui erroreid ei ole käivitan funktsioon mis sisestab andmebaasi
			
			
			if(	$begin_error == "" && $ending_error == "" && $sports_error == "" && $distance_error == "")
			
			{
				$m = createTraining($begin, $ending, $sports, $distance);
			  if($m !=""){
				$begin = "";
				$ending ="";
				$sports = "";
				$distance ="";
			}
			}
		}
}				
				// nimed ei ole olulised
				
 
   function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
  
  //küsime tabeli kujul andmed
  getALLData();
  
 ?>
 
Tere, <?= $_SESSION['logged_in_user_email']; ?> 
<a href="?logout=1">Log out</a>
<br><br>
<form action="table.php">
    <input type="submit" value="Trennid tabelina">
    </form>
	<br><br> 

 
<h2>Uue trenni lisamine</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
     <label for "begin"> Algus </label>
  	    <input id="begin" name="begin" type="datetime-local" value="<?=$begin;?>"> <?=$begin_error;?><br><br>
  	 <label for "ending" > Lõpp </label>
	<input id="ending" name="ending" type="datetime-local" value="<?=$ending;?>"> <?=$ending_error;?><br><br>
	 <label for "sports" > Spordiala </label>
  	<input id="sports" name="sports" type="text" value="<?=$sports;?>"> <?=$sports_error;?><br><br>
  	 <label for "distance"> Distants </label>
	<input id="distance" name="distance" type="text" value="<?=$distance;?>"> <?=$distance_error;?><br><br>
  	<input type="submit" name="add_training" value="Lisa">
	<p style="color:blue;"><?=$m;?><?p>
  </form>
   