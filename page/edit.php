<?php
    require_once("edit_functions.php");
    
    //kasutaja muudab andmeid
    if(isset($_GET["update"])){
        updateContestData($_GET["contest_id"], $_GET["contest_name"], $_GET["name"]);
    }
    
    //kas muutuja on aadressireal
    if(isset($_GET["edit_id"])){
        echo $_GET["edit_id"];
        
        //küsin andmed 
        $all_contest = getSingleContestData($_GET["edit_id"]);
        var_dump ($all_contest);
        
    }else{
        //kui muutujat ei ole, ei ole mõtet siia lehele tulla 
        header("Location: table.php");
    }

?>

<form action="edit.php" method="get">
    <input name="contest_id" type="hidden" value="<?=$_GET["edit_id"];?>">
    <input name="contest_name" type="text" value="<?=$car->contest_name;?>"><br>
    <input name="name" type="text" value="<?=$all_contest->name;?>"><br>
    <input name="update" type="submit">



</form>