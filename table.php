<?php  
    require_once("functions.php");
    
    
	if(isset($_GET["delete"])){
		deleteHomeworkData($_GET["delete"]);
	}
	if(isset($_GET["update"])){
        updateHomeworkData($_GET["homework_id"], $_GET["homework"], $_GET["date"]);
	}
	
	$keyword = "";
    if(isset($_GET["keyword"])){
        $keyword = $_GET["keyword"];
        
        // otsime 
        $homework_array = getAllData($keyword);
    
	}else{
	$homework_array = getAllData();
	}
?>

Tere, <?=$_SESSION['email'];?>

<h1>Tabel</h1>

<form action="table.php" method="get">
    <input name="keyword" type="search" value="<?=$keyword?>" >
    <input type="submit" value="otsi">
<form>

<table border=1>
<tr>
	<th>ID</th>
	<th>Kasutaja ID</th>
	<th>Kodutöö sisu</th>
	<th>Esitamise tähtaeg</th>
	<th><a href="data.php">Lisa uus</a></th>
	<th><a href="?logout=1">Logi välja</a></th>
</tr>

<?php    
    // autod ükshaaval läbi käia
    for($i = 0; $i < count($homework_array); $i++){
        // kasutaja tahab rida muuta
        if(isset($_GET["edit"]) && $_GET["edit"] == $homework_array[$i]->id){
            echo "<tr>";
            echo "<form action='table.php' method='get'>";
            // input mida välja ei näidata
            echo "<input type='hidden' name='homework_id' value='".$homework_array[$i]->id."'>";
            echo "<td>".$homework_array[$i]->id."</td>";
            echo "<td>".$homework_array[$i]->user."</td>";
            echo "<td><input name='homework' value='".$homework_array[$i]->homework."' ></td>";
            echo "<td><input name='date' value='".$homework_array[$i]->date."' ></td>";
            echo "<td><input name='update' type='submit'></td>";
            echo "<td><a href='table.php'>cancel</a></td>";
            echo "</form>";
            echo "</tr>";
        }else{
            // lihtne vaade
            echo "<tr>";
            echo "<td>".$homework_array[$i]->id."</td>";
            echo "<td>".$homework_array[$i]->user."</td>";
            echo "<td>".$homework_array[$i]->homework."</td>";
            echo "<td>".$homework_array[$i]->date."</td>";
            echo "<td><a href='?delete=".$homework_array[$i]->id."'>X</a></td>";
            echo "<td><a href='?edit=".$homework_array[$i]->id."'>edit</a></td>";
			echo "<td><a href='edit.php?edit_id=".$homework_array[$i]->id."'>edit.php</a></td>";
            echo "</tr>";
            
        }
        
        
        
        
    }
    
?>