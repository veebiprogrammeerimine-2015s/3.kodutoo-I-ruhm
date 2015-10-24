
<?php
	require_once("functions.php"); 

	if(!isset($_SESSION['logged_in_user_id'])){
		header("Location: login.php");
	}
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php"); 
	}

	if(isset($_GET["delete"])){
		
		deleteHabitat($_GET["delete"]);
	}
	if(isset($_GET["update"])){
		updateHabitat($_GET["habitat_id"], $_GET["gps_point"], $_GET["location"],  $_GET["habitat_name"],  $_GET["habitat_code"]);
	}
	
	$habitat_array = getAllData();
	$keyword = "";
	
	if(isset($_GET["keyword"])){
		
		$keyword = $_GET["keyword"];
		$habitat_array = getAllData($keyword);
		
	}else{
		
		$habitat_array = getAllData();
	}
	
?>

<h1>Natura 2000 ranniku elupaikade koondtabel</h1>

<a href="data.php">Sisesta uus elupaik</a><br>

<br><a href="?logout=1">Logi välja!</a><br>

<br><form action="table.php" method="get">
	<input name="keyword" type="search" value="<?=$keyword?>">
	<input type="submit" value="otsi">
</form>

<table border=1>
<tr>
	<th>ID</th>
	<th>Kasutaja ID</th>
	<th>GPS-punkt</th>
	<th>Elupaiga asukoht</th>
	<th>Elupaiga nimetus</th>
	<th>Elupaiga kood</th>
	<th>Kustuta</th>
	<th>Muuda kirjet</th>

	
</tr>
<?php
	
	for($i = 0; $i < count($habitat_array); $i++){
		

		if(isset($_GET["edit"]) && $_GET["edit"] && $_GET["edit"] && $_GET["edit"] ==  $habitat_array[$i]->id){
			
			echo "<tr>";
			echo "<form action='table.php' method='get'>";
			echo "<input type='hidden' name='habitat_id' value='".$habitat_array[$i]->id."'>";
			
			echo "<td>".$habitat_array[$i]->id."</td>";
			echo "<td>".$habitat_array[$i]->user_id."</td>";
			echo "<td><input name='gps_point' value='".$habitat_array[$i]->gps_point."'></td>";
			echo "<td><input name='location' value='".$habitat_array[$i]->location."'></td>";
			echo "<td><input name='habitat_name' value='".$habitat_array[$i]->habitat_name."'></td>";
			echo "<td><input name='habitat_code' value='".$habitat_array[$i]->habitat_code."'></td>";
			echo "<td><input name='update' type='submit'></td>";
			echo "<td><a href='table.php'>tühista</a></td>";
			
			echo"</tr>";
			
		}else{
			echo "<tr><td>".$habitat_array[$i]->id."</td>";
			echo "<td>".$habitat_array[$i]->user_id."</td>";
			echo "<td>".$habitat_array[$i]->gps_point."</td>";
			echo "<td>".$habitat_array[$i]->location."</td>";
			echo "<td>".$habitat_array[$i]->habitat_name."</td>";
			echo "<td>".$habitat_array[$i]->habitat_code."</td>";
			
			echo "<td><a href='?delete=".$habitat_array[$i]->id."'>X</a></td>";
			echo "<td><a href='edit.php?edit_id=".$habitat_array[$i]->id."'>muuda</a></td>";
		
			echo "</tr>";
		
		}
		
	}
	
?>

</table>