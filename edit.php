<?php
    require_once("edit_functions.php");
     
    //Kasutaja muudab andmeid
    if(isset($_GET["update"])){
        //auto id, auto number, auto värv
        updateCarData($_GET["user_id"], $_GET["prillivarv"], $_GET["materjal"]);
    }
     
    //kas muutuja on aadressireal
    if(isset($_GET["edit_id"])){
        //trükin aadressirealt muutuja
        echo $_GET["edit_id"];
        
        //küsin andmed
        $evo_glasses = getSingleCarData($_GET["edit_id"]);
        var_dump($evo_glasses);
        
    }else{
        
        //kui muutujat ei ole,
        // ei ole mõtet siia lehele tulla
        // suunan tagasi table.php
        header("Location: table.php");
        
    }
    
    
    
?>
<!-- Salvestamiseks kasutan table.php rida 15, updateCar() -->
<form action="edit.php" method="get" >
    <input name="car_id" type="hidden" value="<?=$_GET["edit_id"];?>">
    <input name="prillivarv" type="text" value="<?=$evo_glasses->prillivarv;?>" ><br>
    <input name="materjal" type="text" value="<?=$evo_glasses->materjal;?>"><br>
    <input name="update" type="submit" >
</form>

