<?php
	require_once("functions.php");
	
	if(isset($_GET["delete"])) {
		deleteCarData($_GET["delete"]);
	}
	
	if(isset($_GET["edit"])){
		editCarData($_GET["carmodel"], $_GET["mileage"], $_GET["cost"], $_GET["description"]);
	}
	
	$keyword = "";
	if(isset($_GET["keyword"])){
		$keyword = $_GET["keyword"];
		
		$car_array = getAllData($keyword);
		
	}else{
		$car_array = getAllData();
	}
	?>
	
	<h1>Tabel</h1>
	<form action="table.php" method="get">
		<input name="keyword" type="search" value="<?=$keyword?>">
		<input type="submit" value="otsi">
	<form>
	<br><br>
	<table border=1>
	<tr>
	<th>id</th>
    <th>kasutaja id</th>
    <th>auto</th>
    <th>läbisõit</th>
    <th>kulu</th>
    <th>kirjeldus</th>
    <th></th>
	</tr>
<?php

	for($i = 0; $i < count($car_array); $i++){
		
	if(isset($_GET["edit"]) && $_GET["edit"] == $car_array[$i]->id){
		echo "<tr>";
            echo "<form action='table.php' method='get'>";
            // input mida välja ei näidata
            echo "<input type='hidden' name='car_id' value='".$car_array[$i]->id."'>";
            echo "<td>".$car_array[$i]->id."</td>";
            echo "<td>".$car_array[$i]->user_id."</td>";
            echo "<td><input name='carmodel' value='".$car_array[$i]->carmodel."' ></td>";
            echo "<td><input name='mileage' value='".$car_array[$i]->mileage."' ></td>";
			echo "<td><input name='cost' value='".$car_array[$i]->cost."' ></td>";
			echo "<td><input name='description' value='".$car_array[$i]->description."' ></td>";
            echo "<td><input name='update' type='submit'></td>";
            echo "<td><a href='table.php'>cancel</a></td>";
            echo "</form>";
            echo "</tr>";
		 }else{
            // lihtne vaade
            echo "<tr>";
            echo "<td>".$car_array[$i]->id."</td>";
            echo "<td>".$car_array[$i]->user_id."</td>";
            echo "<td>".$car_array[$i]->carmodel."</td>";
            echo "<td>".$car_array[$i]->mileage."</td>";
			echo "<td>".$car_array[$i]->cost."</td>";
			echo "<td>".$car_array[$i]->description."</td>";
            echo "<td><a href='?delete=".$car_array[$i]->id."'>X</a></td>";
            echo "<td><a href='?edit=".$car_array[$i]->id."'>edit</a></td>";
            echo "<td><a href='edit.php?edit_id=".$car_array[$i]->id."'>edit.php</a></td>";
            echo "</tr>";
		}
	}
	
?>
</table>