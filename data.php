<?php
    // kõik mis seotud andmetabeliga, lisamine ja tabeli kujul esitamine
    require_once("functions.php");
    
    //kui kasutaja ei ole sisse logitud, suuna teisele lehele
    //kontrollin kas sessiooni muutuja olemas
    if(!isset($_SESSION['logged_in_user_id'])){
        header("Location: login.php");
    }
    
    // aadressireale tekkis ?logout=1
    if(isset($_GET["logout"])){
        //kustutame sessiooni muutujad
        session_destroy();
        header("Location: login.php");
    }
	
	
	// muutujad väärtustega
	$m = "";
	$kodus = "";
	$kodus_error = "";
	$nimi = "";
	$nimi_error = "";
	$sugu = "";
	$sugu_error = "";
	$vanus = "";
	$vanus_error = "";
	$kirjeldus = "";
	$kirjeldus_error = "";
	//echo $_SESSION ['logged_in_user_id'];
	
	echo "kodus: ----".$kodus;
	
	// valideeri
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		if(isset($_POST["add_cat"])){
		
			if (empty($_POST["kodus"]))  {
				$kodus_error = "Kassi elukoha määramine on kohustuslik";
			}else{
				$kodus = cleanInput($_POST["kodus"]);
			}
			
			if (empty($_POST["kirjeldus"]))  {
				$kirjeldus_error = "Kassi kirjelduse lisamine on kohustuslik";
			}else{
				$kirjeldus = cleanInput($_POST["kirjeldus"]);
			}
			
			if (empty($_POST["nimi"]))  {
				$nimi = "";
			}else{
				$nimi = cleanInput($_POST["nimi"]);
			}
			
			if (empty($_POST["vanus"]))  {
				$vanus = "";
			}else{
				$vanus = cleanInput($_POST["vanus"]);
			}
			
			if (empty($_POST["sugu"]))  {
				$sugu = "";
			}else{
				$sugu = cleanInput($_POST["sugu"]);
			}
			
			
			if($kodus_error == "" && $kirjeldus_error == ""){
				echo "siin";
				$m=createCat($nimi, $vanus, $sugu, $kirjeldus, $kodus);
				
				
			}
		}
	}
		
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	getAllCats();
	
  	
	
	
	
	//kõik objektide kujul massiivis
	$cat_array=getAllCats();
	
	$keyword="";
	if(isset($_GET["keyword"])){
		$keyword=$_GET["keyword"];
		
		//otsime
		$cat_array=getAllCats($keyword);
		
	}else{
		//näitame kõiki tulemusi
		//kõik objektide kujul massiivis
		$cat_array=getAllCats();
	}
	
	//kasutaja muudab andmeid
	if(isset($_GET["update"])){
		
		updateCatData($_GET["cat_id"], $_GET["vanus"], $_GET["kodus"], $_GET["kirjeldus"]);
	}
	
?>



Tere, <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1">Logi välja</a>

<h2>Kasside tabel</h2>
<form action="otsivad.php" method="get">
	<input name="keyword" type="search" value="<?=$keyword?>" >
	<input type="submit" value="otsi"> 
</form>

<br>
<table border=1>
<tr>

	<th>Nimi</th>
	<th>Vanus</th>
	<th>Sugu</th>
	<th>Kirjeldus</th>
	<th>Kodus</th>

</tr>

<?php 
	
	//ükshaaval läbi käia
	for($i=0; $i<count($cat_array); $i++){
		
		//kasutaja tahab rida muuta
		if(isset($_GET["edit"]) && $_GET["edit"]==$cat_array[$i]->id){
			echo "<tr>";
			echo "<form action='data.php' method='get'>";
			
			//input mida välja ei näidata 
			echo "<input type='hidden' name='cat_id' value='".$cat_array[$i]->id."'>";
			echo "<td>".$cat_array[$i]->nimi."</td>";
			echo "<td><input name='vanus' value=".$cat_array[$i]->vanus."></td>";
			echo "<td>".$cat_array[$i]->sugu."</td>";
			echo "<td><input name='kirjeldus' value=".$cat_array[$i]->kirjeldus."></td>";
			echo "<td><input name='kodus' value=".$cat_array[$i]->kodus."></td>";
			echo "<td><input name='update' type='submit'></td>";
			echo "<td><input name='update'></td>";
			echo "<td><a href='data.php'>Katkesta</a></td>";
			echo "</form>";
			echo "</tr>";
			
		}else{
		
			//lihtne vaade
			echo "<tr>";
			echo "<td>".$cat_array[$i]->nimi."</td>";
			echo "<td>".$cat_array[$i]->vanus."</td>";
			echo "<td>".$cat_array[$i]->sugu."</td>";
			echo "<td>".$cat_array[$i]->kirjeldus."</td>";
			echo "<td>".$cat_array[$i]->kodus."</td>";
			echo "<td><a href='?edit=".$cat_array[$i]->id."'>Edit</a></td>";
			echo "</tr>";
		}
	}

?>

</table>

<h2> Lisa uus kass</h2>

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  
	<label for="nimi"> Nimi </label>
  	<input id="nimi" name="nimi" type="text" value="<?=$nimi; ?>"> <?=$nimi_error; ?><br><br>
	
	<label for="sugu"> Sugu </label>
  	<input id="sugu" name="sugu" type="text" value="<?=$sugu; ?>"> <?=$sugu_error; ?><br><br>
	
	<label for="vanus"> Vanus </label>
  	<input id="vanus" name="vanus" type="int" value="<?=$vanus; ?>"> <?=$vanus_error; ?><br><br>
	
	<label for="kirjeldus"> Kirjeldus </label>
  	<input id="kirjeldus" name="kirjeldus" type="text" value="<?=$kirjeldus; ?>"> <?=$kirjeldus_error; ?><br><br>
	
	<label for="kodus"> Kodus? </label>
  	<input id="kodus" name="kodus" type="text" value="<?=$kodus; ?>"> <?=$kodus_error; ?><br><br>
	
	
  	<input type="submit" name="add_cat" value="Lisa">
	<p style="color:green;"><?=$m;?></p>
	
  </form>  