<?php  
    require_once("functions.php");
    
    
    // kuulan, kas kasutaja tahab kustutada
    // ?delete=... on aadressireal
    if(isset($_GET["delete"])) {
        ///saadan kustutatava auto id
        deletePostData($_GET["delete"]);
    }
    
    //Kasutaja muudab andmeid
    if(isset($_GET["update"])){
        //auto id, auto number, auto värv
        updatePostData($_GET["user_id"], $_GET["postitus"]);
    }
    
    
    
    // kõik autod objektide kujul massiivis
    $post_array = getAllData();
?>

<h1>Tabel</h1>
<table border=1>
<tr>
    <th>id</th>
    <th>kasutaja id</th>
    <th>Postitus</th>
    <th>Kustuta</th>
    <th>Muuda</th>
</tr>
<?php 
    
    // autod ükshaaval läbi käia
    for($i = 0; $i < count($post_array); $i++){
        
        // kasutaja tahab rida muuta
        if(isset($_GET["edit"]) && $_GET["edit"] == $post_array[$i]->id){
            echo "<tr>";
            echo "<form action='table.php' method='get'>";
            // input mida välja ei näidata
            echo "<input type='hidden' name='user_id' value='".$post_array[$i]->id."'>";
            echo "<td>".$post_array[$i]->id."</td>";
            echo "<td>".$post_array[$i]->user_id."</td>";
            echo "<td><input name='postitus' value='".$post_array[$i]->postitus."' ></td>";
            echo "<td><input name='update' type='submit'></td>";
            echo "<td><a href='table.php'>cancel</a></td>";
            echo "</form>";
            echo "</tr>";
        }else{
            // lihtne vaade
            echo "<tr>";
            echo "<td>".$post_array[$i]->id."</td>";
            echo "<td>".$post_array[$i]->user_id."</td>";
            echo "<td>".$post_array[$i]->postitus."</td>";
            echo "<td><a href='?delete=".$post_array[$i]->id."'>X</a></td>";
            echo "<td><a href='?edit=".$post_array[$i]->id."'>edit</a></td>";
            echo "</tr>";
            
        }
        
        
        
        
    }
    
?>
</table>