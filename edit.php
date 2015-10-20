<?php
    require_once("edit_functions.php");
     
    //Kasutaja muudab andmeid
    if(isset($_GET["update"])){
        //auto id, auto mudel, auto läbisõit, kulu, kirjeldus
        updateCarData($_GET["car_id"], $_GET["carmodel"], $_GET["mileage"], $_GET["cost"], $_GET["description"]);
	}
	//kas muutuja on aadressireal
	if(isset($_GET["edit_id"])){
        //trükin aadressirealt muutuja
        echo $_GET["edit_id"];
        
        //küsin andmed
        $car = getSingleCarData($_GET["edit_id"]);
        var_dump($car);
        
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
    <input name="carmodel" type="text" value="<?=$car->carmodel;?>" ><br>
    <input name="mileage" type="text" value="<?=$car->mileage;?>"><br>
	<input name="cost" type="text" value="<?=$car->cpst;?>"><br>
	<input name="description" type="text" value="<?=$car->description;?>"><br>
    <input name="update" type="submit" >
</form>