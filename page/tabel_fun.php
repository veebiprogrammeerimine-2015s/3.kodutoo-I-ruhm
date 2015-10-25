<?php  
    require_once("../../config_global.php");
    $database = "if15_klinde";
    
    function getAllData(){
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        //deleted IS NULL ehk kustutab ära 
        $stmt = $mysqli->prepare("SELECT id, user_id, contest_name, name FROM contests WHERE deleted IS NULL");
        $stmt->bind_result($id_from_db, $user_id_from_db, $contest_name_from_db, $name_from_db);
        $stmt->execute();
  
        // iga rea kohta mis on ab'is teeme midagi
        
        //massiiv, kus hoiame autosid
        $array = array(); 
        
        while($stmt->fetch()){
            //suvaline muutuja, kus hoida auto andmeid, hetkeni kuni lisame massiivi
            
            //tühi objekt, kus hoiame väärtuseid
            $all_contest = new StdClass();
            $all_contest->id = $id_from_db;
            $all_contest->contest_name = $contest_name_from_db;
            $all_contest->user_id = $user_id_from_db;
            $all_contest->name = $name_from_db;
            
            //lisan massiivi - auto lisan massiivi
            array_push($array, $all_contest);
            //echo "<pre>";
            //var_dump($array); 
            //echo "</pre>";
            
        }
        //saadan tagasi
        return $array;
        
        $stmt->close();
        $mysqli->close();
    }
    
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