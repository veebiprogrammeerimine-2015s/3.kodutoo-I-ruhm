<?php

   require_once("edit_functions.php");
   
   if(isset($_GET["update"])){
      updateTrainingData($_GET["training_id"], $_GET["begin"], $_GET["ending"], $_GET["sports"], $_GET["distance"]);
	} 
 
   if(isset($_GET["edit_id"])){
	//trükin aadressirealt muutuja   
     echo $_GET["edit_id"];
    
 
	
	// //küsin andmed 
    $training = getSingleTrainingData($_GET["edit_id"]); 
    var_dump($training); 


    }else{ 
	//kui muutujat ei ole (siis ei ole mõtet siia tulla)
	header("Location: table.php");
	
	
	}
?> 
<!-- Salvestamiseks kasutan table.php rida 15, updateTraining() -->
 <form action="edit.php" method="get">
  <input name="training_id" type="hidden" value="<?=$_GET["edit_id"];?>">
  <input name="begin" type="text" value="<?=$training->begin;?>" ><br>
  <input name="ending" type="text" value="<?=$training->ending;?>"><br>
  <input name="sports" type="text" value="<?=$training->sports;?>" ><br>
  <input name="distance" type="text" value="<?=$training->distance;?>"><br>
  <input name="update" type="submit" >
 </form>