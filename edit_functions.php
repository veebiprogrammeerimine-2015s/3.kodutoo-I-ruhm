<?php
    //edit_functions.php
    require_once("../config_global.php");
    $database = "if15_kelllep";
    
    function getSinglePostData($id){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("SELECT user_id, postitus FROM postitus WHERE id=? AND deleted IS NULL");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($id, $postitus);
        $stmt->execute();
        
        // postituse objekt
        $post = new StdClass();
        
        // kas sain rea andmeid
        if($stmt->fetch()){
            
            $post->postitus = $postitus;

            
        }else{
            // ei tulnud 
            // kui id ei olnud (vale id)
            // või on kustutatud (deleted ei ole null)
            header("Location: table.php");
        }
        
        $stmt->close();
        $mysqli->close();
        
        return $post;
        
    }
    
    function updatePostData($user_id, $postitus){
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("UPDATE postitus SET postitus=? WHERE id=?");
        $stmt->bind_param("si", $postitus, $user_id);
        $stmt->execute();
        
        // tühjendame aadressirea
        header("Location: table.php");
        
        $stmt->close();
        $mysqli->close();
        
    }
    
    
?>