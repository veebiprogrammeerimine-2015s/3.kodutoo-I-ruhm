<?php require_once ("header.php"); ?>


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
	$home = "";
	$home_error = "";
	$name = "";
	$name_error = "";
	$gender = "";
	$gender_error = "";
	$age = "";
	$age_error = "";
	$description = "";
	$description_error = "";
	//echo $_SESSION ['logged_in_user_id'];
	
	// valideeri
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		if(isset($_POST["add_cat"])){
		
			if (empty($_POST["home"]))  {
				$home_error = "Kassi elukoha määramine on kohustuslik";
			}else{
				$home = cleanInput($_POST["home"]);
			}
			
			if (empty($_POST["description"]))  {
				$description_error = "Kassi kirjelduse lisamine on kohustuslik";
			}else{
				$description = cleanInput($_POST["description"]);
			}
			
			if (empty($_POST["name"]))  {
				$name = "";
			}else{
				$name = cleanInput($_POST["name"]);
			}
			
			if (empty($_POST["age"]))  {
				$age = "";
			}else{
				$age = cleanInput($_POST["age"]);
			}
			
			if (empty($_POST["gender"]))  {
				$gender = "";
			}else{
				$gender = cleanInput($_POST["gender"]);
			}
			
			
			if($home_error == "" && $description_error == ""){
				echo "siin";
				$m=createCat($name, $age, $gender, $description, $home);
				
				
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
	
  	// kuulan kas kasutaja tahab kustutada
	//?delete=.. on aadressireal
	if(isset($_GET["delete"])){
		//saadan kustutatava kirje id
		
		if(isset($_SESSION['logged_in_user_id'])){
		
			deleteCatData($_GET["delete"]);
		
		}
		
	}
	//kasutaja muudab andmeid
	if(isset($_GET["update"])){
		
		if(isset($_SESSION['logged_in_user_id'])){
			
		updateCatData($_GET["cat_id"], $_GET["age"], $_GET["home"], $_GET["description"]);
		
		}
		
	}
	
	
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

	<th>name</th>
	<th>age</th>
	<th>gender</th>
	<th>description</th>
	<th>home</th>
	<th>Edit</th>
	<th>Delete</th>

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
			echo "<td>".$cat_array[$i]->name."</td>";
			echo "<td><input name='age' value=".$cat_array[$i]->age."></td>";
			echo "<td>".$cat_array[$i]->gender."</td>";
			echo "<td><input name='description' type='text' value='".$cat_array[$i]->description."'></td>";
			echo "<td><input name='home' value=".$cat_array[$i]->home."></td>";
			echo "<td><input name='update' type='submit'></td>";
			echo "<td><a href='data.php'>Katkesta</a></td>";
			echo "</form>";
			echo "</tr>";
			
		}else{
		
			//lihtne vaade
			echo "<tr>";
			echo "<td>".$cat_array[$i]->name."</td>";
			echo "<td>".$cat_array[$i]->age."</td>";
			echo "<td>".$cat_array[$i]->gender."</td>";
			echo "<td>".$cat_array[$i]->description."</td>";
			echo "<td>".$cat_array[$i]->home."</td>";
			echo "<td><a href='?edit=".$cat_array[$i]->id."'>Edit</a></td>";
			echo "<td><a href='?delete=".$cat_array[$i]->id."'>X</a></td>";
			echo "</tr>";
		}
	}

?>

</table>

<h2> Lisa uus kass</h2>

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  
	<label for="name"> name </label>
  	<input id="name" name="name" type="text" value="<?=$name; ?>"> <?=$name_error; ?><br><br>
	
	<label for="gender"> gender </label>
  	<input id="gender" name="gender" type="text" value="<?=$gender; ?>"> <?=$gender_error; ?><br><br>
	
	<label for="age"> age </label>
  	<input id="age" name="age" type="int" value="<?=$age; ?>"> <?=$age_error; ?><br><br>
	
	<label for="description"> description </label>
  	<input id="description" name="description" type="text" value="<?=$description; ?>"> <?=$description_error; ?><br><br>
	
	<label for="home"> home? </label>
  	<input id="home" name="home" type="text" value="<?=$home; ?>"> <?=$home_error; ?><br><br>
	
	
  	<input type="submit" name="add_cat" value="Lisa">
	<p style="color:green;"><?=$m;?></p>
	
  </form>  
  
  <?php require_once ("footer.php"); ?>