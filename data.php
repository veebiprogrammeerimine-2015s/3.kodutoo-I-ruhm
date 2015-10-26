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

	
	//MUUTUJAD
	$job_name = $job_desc = $job_company = $job_county = $job_parish = $job_location = $job_address = "";
	$job_name_error = $job_desc_error = $job_company_error = $job_county_error = $job_parish_error = $job_location_error = $job_address_error = "";
	$m = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
        
		if(isset($_POST["add_job"])){
			if (empty($_POST["job_name"])) {
				$job_name_error = "Ameti nimi on kohustuslik";
			} else {
				$job_name = cleanInput($_POST["job_name"]);

			}
			if (empty($_POST["job_desc"])) {
				$job_desc_error = "Töö kirjeldus on kohustuslik";
			} else {
				$job_desc = cleanInput($_POST["job_desc"]);

			}
			if (empty($_POST["job_company"])) {
				$job_company_error = "Asutus on kohustuslik";
			} else {
				$job_company = cleanInput($_POST["job_company"]);

			}
			if (empty($_POST["job_county"])) {
				$job_county_error = "Maakond on kohustuslik";
			} else {
				$job_county = cleanInput($_POST["job_county"]);

			}
			if (empty($_POST["job_parish"])) {
				$job_parish_error = "Vald on kohustuslik";
			} else {
				$job_parish = cleanInput($_POST["job_parish"]);

			}
			if (empty($_POST["job_location"])) {
				$job_location_error = "Asula on kohustuslik";
			} else {
				$job_location = cleanInput($_POST["job_location"]);

			}
			if (empty($_POST["job_address"])) {
				$job_address_error = "Aadress on kohustuslik";
				
			} else {
				$job_address = cleanInput($_POST["job_address"]);

			}
			
			//Errorite puudumisel käivitub funktsioon, mis sisestab andmebaasi
			if ($job_name_error == "" && $job_desc_error == "" && $job_company_error == "" && $job_county_error == "" && $job_parish_error == "" && $job_location_error == "" && $job_address_error == "") {
				//m - message, mis tuleb functions.php failist
				$m = createJob($job_name, $job_desc, $job_company, $job_county, $job_parish, $job_location, $job_address);
			}
      if ($m != "") {
				//Vorm tühjaks
				$job_name = "";
				$job_desc = "";
				$job_company = "";
				$job_county = "";
				$job_parish = "";
				$job_location = "";
				$job_address = "";
			}   
				 
    }
            
  }
    
    
    // kirjuta fn 

	//Küsime tabeli kujul andmed
	getAllData();
	
?>

<?php
	//Lehe nimi
	$page_title = "Uus töökoht";
	//Faili nimi
	$page_file = "data.php";
?>

<?php require_once("header.php"); ?>

<h2>Lisa uus töökoht</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >

    <label for="job_name"> Amet </label>
  	<input id="job_name" name="job_name" type="text" value="<?=$job_name;?>"> <?=$job_name_error;?><br><br>
		
  	<label for="job_desc"> Töö kirjeldus </label>
    <input id="job_desc" name="job_desc" type="text" value="<?=$job_desc;?>"> <?=$job_desc_error;?><br><br>
		
   	<label for="job_company"> Asutus </label>
    <input id="job_company" name="job_company" type="text" value="<?=$job_company;?>"> <?=$job_company_error;?><br><br> 	
		
  	<label for="job_county"> Maakond </label>
    <input id="job_county" name="job_county" type="text" value="<?=$job_county;?>"> <?=$job_county_error;?><br><br>

  	<label for="job_parish"> Vald </label>
    <input id="job_parish" name="job_parish" type="text" value="<?=$job_parish;?>"> <?=$job_parish_error;?><br><br>

  	<label for="job_location"> Asula </label>
    <input id="job_location" name="job_location" type="text" value="<?=$job_location;?>"> <?=$job_location_error;?><br><br>

  	<label for="job_address"> Aadress </label>
    <input id="job_address" name="job_address" type="text" value="<?=$job_address;?>"> <?=$job_address_error;?><br><br>
		
		<input type="submit" name="add_job" value="Lisa">
		
		
		
	<p style="color: green;"><?=$m;?></p>
	
  </form>
	
	
	
<?php require_once("footer.php"); ?>
	