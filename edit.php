<?php
    require_once("edit_functions.php");
     
    //Kasutaja muudab andmeid
    if(isset($_GET["update"])){

        updatePostData($_GET["user_id"], $_GET["postitus"]);
    }
     
    //kas muutuja on aadressireal
    if(isset($_GET["edit_id"])){
        //trükin aadressirealt muutuja
        echo $_GET["edit_id"];
        
        //küsin andmed
        $post = getSinglePostData($_GET["edit_id"]);
        var_dump($post);
        
    }else{
        
        //kui muutujat ei ole,
        // ei ole mõtet siia lehele tulla
        // suunan tagasi table.php
        header("Location: table.php");
        
    }
    
    
    
?>


<form action="edit.php" method="get" >
    <input name="user_id" type="hidden" value="<?=$_GET["edit_id"];?>">
    <input name="postitus" type="text" value="<?=$post->postitus;?>" ><br>
    <input name="update" type="submit" >
</form>

