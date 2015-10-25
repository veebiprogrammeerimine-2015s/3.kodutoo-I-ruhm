<?php 
    require_once("tabel_fun.php");
    
    //kuulan, kas kasutaja tahab kustutada
    if(isset($_GET["delete"])){
        //saadan kustutatava auto id
        deleteContestData($_GET["delete"]);
    }
    
    //kasutaja muudab andmeid
    if(isset($_GET["update"])){
        updateContestData($_GET["contest_id"], $_GET["contest_name"], $_GET["name"]);
    }
    
    //kõik autod objektide kujul massiivis
    $contest_array = getAllData();
?>

<h1>Tabel</h1>
<table border=1>
<tr>
    <th>id</th>
    <th>Kasutaja id</th>
    <th>Võistluse nimi</th>
    <th>Osaleja nimi/klubi</th>
    <th>Kustuta</th>
    <th>Muuda</th>
</tr>
<?php
    //autod ükshaaval läbi käia
    for($i = 0; $i < count($contest_array); $i++){
        
        //kasutaja tahab rida muuta
        if(isset($_GET["edit"]) && $_GET["edit"] == $contest_array[$i]->id){
            echo "<tr>";
            echo "<form action='table.php' method='get'>";
            // input mida välja ei näidata
            echo "<input type='hidden' name='contest_id' value='".$contest_array[$i]->id."'>";
            echo "<td>".$contest_array[$i]->id."</td>";
            echo "<td>".$contest_array[$i]->user_id."</td>";
            echo "<td><input name='contest_name' value='".$contest_array[$i]->contest_name."'></td>";
            echo "<td><input name='name' value='".$contest_array[$i]->name."'></td>";            
            echo "<td><a href='?table.php=".$contest_array[$i]->id."'>Katkesta</a></td>";
            echo "<td><input name='update' type='submit'></td>";
            echo "</form>";
            echo "</tr>";
        }else{
            //lihtne vaade
            echo "<tr>";
            echo "<td>".$contest_array[$i]->id."</td>";
            echo "<td>".$contest_array[$i]->user_id."</td>";
            echo "<td>".$contest_array[$i]->contest_name."</td>";
            echo "<td>".$contest_array[$i]->name."</td>";
            echo "<td><a href='?delete=".$contest_array[$i]->id."'>X</a></td>";
            echo "<td><a href='?edit=".$contest_array[$i]->id."'>Muuda</a></td>";
            echo "</tr>";
            
        }
        
        
    }
    
?>
</table>