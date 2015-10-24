<?php

	require_once("edit_functions.php"); 
	
	if(isset($_GET["update"])){
		updateHabitat($_GET["habitat_id"], $_GET["gps_point"], $_GET["location"], $_GET["habitat_name"], $_GET["habitat_code"]);
	}
	

	if(isset($_GET["edit_id"])){
		
		$habitat = getHabitatData($_GET["edit_id"]);
		
	}else{
		header("Location: table.php");
	}

?>
<p>Muuda tabeli kirje andmeid:</p>
<form action="edit.php" method="get">
	<input name="habitat_id" type="hidden" value="<?=$_GET["edit_id"];?>"><br>
	<input name="gps_point" type="text" value="<?=$habitat->gps_point;?>"> GPS-PUNKT<br> <br>
	<input name="location" type="text" value="<?=$habitat->location;?>"> Asukoht<br><br>
	<input name="habitat_name" type="text" placeholder="nt. Valge luide" value="<?=$habitat->habitat_name;?>"> Elupaiga nimi<br><br>
	<input name="habitat_code" type="text" placeholder="nt. 1210" value="<?=$habitat->habitat_code;?>"> Elupaiga kodeering<br><br>
	<input name="update" type="submit"><br>
	

</form>
<a href="table.php">Tühista</a>