<?php
    require_once("edit_functions.php");
	
	
	if(isset($_GET["update"])){
        updateHomeworkData($_GET["homework_id"], $_GET["homework"], $_GET["date"]);
	}
     
    //kas muutuja on aadressireal
    if(isset($_GET["edit_id"])){
        //tr�kin aadressirealt muutuja
        echo $_GET["edit_id"];
        
        //k�sin andmed
        $homework = getSingleHomeworkData($_GET["edit_id"]);
        var_dump($homework);
        
    }else{
        
        //kui muutujat ei ole,
        // ei ole m�tet siia lehele tulla
        // suunan tagasi table.php
        header("Location: table.php");
        
    }
?>
<form action="edit.php" method="get" >
    <input name="homework_id" type="hidden" value="<?=$_GET["edit_id"];?>">
    <input name="homework" type="text" value="<?=$homework->homework;?>" ><br>
    <input name="date" type="text" value="<?=$homework->date;?>"><br>
    <input name="update" type="submit" >
</form>
