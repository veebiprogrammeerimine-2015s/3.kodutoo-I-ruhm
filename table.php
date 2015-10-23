<?php
require_once("functions.php");

   // kuulan, kas kasutaja tahab kustutada
   if(isset($_GET["delete"])) {
	   deleteTrainingData($_GET["delete"]);
   }
   
   if(isset($_GET["update"])){
      updateTrainingData($_GET["training_id"], $_GET["begin"], $_GET["ending"], $_GET["sports"], $_GET["distance"]);
	}  
	
    
	  $keyword = "";
   if(isset($_GET["keyword"])){
      $keyword=$_GET["keyword"];
	  //otsime
	  $training_array = getAllData($keyword);
	  
	} else{
	$training_array = getAllData();	
		
	} 
?> 

 <h1>Tabel</h1> 
 <form action="table.php" method="get">
    <input name="keyword" type="search" value="<?=$keyword?>">
	<input type="submit" value="otsi">
	</form>	
	<br><br>
 <table border=1>
 <tr>
    <th>training_ID</th>
	<th>user_ID</th>
	<th>Begin</th>
	<th>Ending</th>
	<th>Sports</th>
	<th>Distance</th>
    <th>Delete</th>
    <th>Edit</th>
	<th></th>
</tr>  
 <?php
 
      //trennid ükshaaval läbi käia
    for($i = 0; $i < count($training_array); $i++){
		
		//kasutaja tahab rida muuta
	  if(isset($_GET["edit"])&& $_GET["edit"]==$training_array[$i]->training_id){
		echo "<tr>";
		echo "<form action='table.php' method='get'>";
		echo "<input type='hidden' name='training_id' value='".$training_array[$i]->training_id."'>"; 
		echo "<td>".$training_array[$i]->training_id."</td>";  
        echo "<td>".$training_array[$i]->user_id."</td>";  
	    echo "<td><input name='begin' value='".$training_array[$i]->begin."'></td>";  
		echo "<td><input name='ending' value='".$training_array[$i]->ending."'</td>"; 
		echo "<td><input name='sports' value='".$training_array[$i]->sports."'></td>";  
		echo "<td><input name='distance' value='".$training_array[$i]->distance."'</td>"; 
		echo "<td><input name='update' type='submit'></td>";  
		echo "<td><a href='?table.php'>cancel</a></td>";  
	    echo "</form>";
		echo"</tr>";
	
		}else{
	    echo"<tr>";
        echo "<td>".$training_array[$i]->training_id."</td>";  
        echo "<td>".$training_array[$i]->user_id."</td>";  
	    echo "<td>".$training_array[$i]->begin."</td>";  
	    echo "<td>".$training_array[$i]->ending."</td>"; 
		echo "<td>".$training_array[$i]->sports."</td>";  
	    echo "<td>".$training_array[$i]->distance."</td>"; 
	    echo "<td><a href='?delete=".$training_array[$i]->training_id."'>X</a></td>";  
		echo "<td><a href='?edit=".$training_array[$i]->training_id."'>edit</a></td>";
        echo "<td><a href='edit.php?edit_id=".$training_array[$i]->training_id."'>edit.php</a></td>";
        echo "</tr>"; 
	
	}
	
	
   }
	
  
?> 
</table>