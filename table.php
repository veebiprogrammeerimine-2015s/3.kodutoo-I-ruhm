<?php  
    require_once("functions.php");
    
    
    // kuulan, kas kasutaja tahab kustutada
    // ?delete=... on aadressireal
    if(isset($_GET["delete"])) {
        ///saadan kustutatava auto id
        deleteGlassData($_GET["delete"]);
    }
    
    //Kasutaja muudab andmeid
    /*if(isset($_GET["update"])){
        //auto id, auto number, auto värv
        updateCarData($_GET["user_id"], $_GET["prillivarv"], $_GET["materjal"]);
    }*/
    
    
    
    // kõik autod objektide kujul massiivis
    $evo_glass_array = getAllData();
?>
<?php
	$page_title = "Prillid";
	$page_file_name = "table.php";

?>

<?php require_once("header.php"); ?>

<h1>Tabel</h1>
<table border=1>
<tr>
    <th>id</th>
    <th>kasutaja id</th>
    <th>Prillivärv</th>
    <th>Materjal</th>
    <th>Kustuta</th>
    <th>Muuda</th>
</tr>
<?php 
    
    // autod ükshaaval läbi käia
    for($i = 0; $i < count($evo_glass_array); $i++){
        
       /* // kasutaja tahab rida muuta
        if(isset($_GET["edit"]) && $_GET["edit"] == $evo_glass_array[$i]->id){
            echo "<tr>";
            echo "<form action='table.php' method='get'>";
            // input mida välja ei näidata
            echo "<input type='hidden' name='evo_glass_id' value='".$evo_glass_array[$i]->id."'>";
            echo "<td>".$evo_glass_array[$i]->id."</td>";
            echo "<td>".$evo_glass_array[$i]->user_id."</td>";
            echo "<td><input name='prillivarv' value='".$evo_glass_array[$i]->prillivarv."' ></td>";
            echo "<td><input name='materjal' value='".$evo_glass_array[$i]->materjal."' ></td>";
            echo "<td><input name='update' type='submit'></td>";
            echo "<td><a href='table.php'>cancel</a></td>";
            echo "</form>";
            echo "</tr>";
        }else{*/
            // lihtne vaade
            echo "<tr>";
            echo "<td>".$evo_glass_array[$i]->id."</td>";
            echo "<td>".$evo_glass_array[$i]->user_id."</td>";
            echo "<td>".$evo_glass_array[$i]->prillivarv."</td>";
            echo "<td>".$evo_glass_array[$i]->materjal."</td>";
           echo "<td><a href='?delete=".$evo_glass_array[$i]->id."'>X</a></td>";
            //echo "<td><a href='?edit=".$evo_glass_array[$i]->id."'>edit</a></td>";
            echo "</tr>";
            
        //}
        
        
        
        
    }
    
?>
</table>