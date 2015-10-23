table inc
<html>
<?php
require_once("functions.php");

$car_array = getAllData();
if(isset($_GET["delete"])) {
        ///saadan kustutatava auto id
        deleteCarData($_GET["delete"]);
    }
       
    
?>
<h1> Tabel </h1>
<table>
<tr> <th>ID</th><th>User ID</th><th>Number plate</th><th>Color</th></tr>
<?php 
for($i = 0; $i < count($car_array); $i++){
	if(isset($_GET["edit"]) && $_GET["edit"] == $car_array[$i]->id) {
	echo "<tr> <td>".$car_array[$i]->id."</td> ";
	echo "<td>".$car_array[$i]->user_id."</td> ";
	echo "<td><input name='number plate' value='".$car_array[$i]->number_plate."'></td>";
	echo "<td><input name='color' value='".$car_array[$i]->color."'></td></tr> ";
     }
	else{
	echo "<tr> <td>".$car_array[$i]->id."</td> ";
	echo "<td>".$car_array[$i]->user_id."</td> ";
	echo "<td>".$car_array[$i]->number_plate."</td>";
	echo "<td>".$car_array[$i]->color."</td> "; 
	echo "<td><a href='?delete=".$car_array[$i]->id."'>X</a></td>";
	echo "<td><a href='?edit=".$car_array[$i]->id."'>Edit</a></td></tr>";
	
	} 
}

?>
</table>
</html>