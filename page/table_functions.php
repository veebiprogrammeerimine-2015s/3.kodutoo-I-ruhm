<?php  
    require_once("../../config_global.php");
    $database = "if15_klinde";
    

    
    function deleteContestData($all_contest_id){
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        //uuendan välja deleted, lisan praeguse date'i
        $stmt = $mysqli->prepare("UPDATE contests SET deleted=NOW() WHERE id=?");
        $stmt->bind_param("i", $all_contest_id);
        $stmt->execute();
        
        //tühjendame aadressirea
        header("Location: table.php");
        
        $stmt->close();
        $mysqli->close();
    }
    
    function updateContestData($all_contest_id, $contest_name, $name){
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        
        $stmt = $mysqli->prepare("UPDATE contests SET contest_name=?, name=? WHERE id=?");
        $stmt->bind_param("ssi", $contest_name, $name, $all_contest_id);
        $stmt->execute();
        header("Location: table.php");
        
        
        $stmt->close();
        $mysqli->close();
    }
 ?>