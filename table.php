<?php  
    require_once("functions.php");
    
    
    // kuulan, kas kasutaja tahab kustutada
    // ?delete=... on aadressireal
    if(isset($_GET["delete"])) {
        ///saadan kustutatava auto id
        deleteCarData($_GET["delete"]);
    }
    
    //Kasutaja muudab andmeid
    if(isset($_GET["update"])){
        //auto id, auto number, auto värv
        updateCarData($_GET["car_id"], $_GET["number_plate"], $_GET["color"]);
    }
    
    
    
    // kõik autod objektide kujul massiivis
    $car_array = getAllData();
?>

<h1>Tabel</h1>
<table border=1>
<tr>
    <th>id</th>
    <th>kasutaja id</th>
    <th>auto numbrimärk</th>
    <th>värv</th>
    <th></th>
    <th></th>
</tr>
<?php 
    
    // autod ükshaaval läbi käia
    for($i = 0; $i < count($car_array); $i++){
        
        // kasutaja tahab rida muuta
        if(isset($_GET["edit"]) && $_GET["edit"] == $car_array[$i]->id){
            echo "<tr>";
            echo "<form action='table.php' method='get'>";
            // input mida välja ei näidata
            echo "<input type='hidden' name='car_id' value='".$car_array[$i]->id."'>";
            echo "<td>".$car_array[$i]->id."</td>";
            echo "<td>".$car_array[$i]->user_id."</td>";
            echo "<td><input name='number_plate' value='".$car_array[$i]->number_plate."' ></td>";
            echo "<td><input name='color' value='".$car_array[$i]->color."' ></td>";
            echo "<td><input name='update' type='submit'></td>";
            echo "<td><a href='table.php'>cancel</a></td>";
            echo "</form>";
            echo "</tr>";
        }else{
            // lihtne vaade
            echo "<tr>";
            echo "<td>".$car_array[$i]->id."</td>";
            echo "<td>".$car_array[$i]->user_id."</td>";
            echo "<td>".$car_array[$i]->number_plate."</td>";
            echo "<td>".$car_array[$i]->color."</td>";
            echo "<td><a href='?delete=".$car_array[$i]->id."'>X</a></td>";
            echo "<td><a href='?edit=".$car_array[$i]->id."'>edit</a></td>";
            echo "</tr>";
            
        }
        
        
        
        
    }
    
?>
</table>