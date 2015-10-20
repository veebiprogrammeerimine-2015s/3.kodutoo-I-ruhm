<?php
    require_once("edit_functions.php");
     
    //Kasutaja muudab andmeid
    if(isset($_GET["update"])){
        //auto id, auto mudel, auto läbisõit, kulu, kirjeldus
        updateCarData($_GET["car_id"], $_GET["carmodel"], $_GET["mileage"], $_GET["cost], $_GET["description"]);
    }