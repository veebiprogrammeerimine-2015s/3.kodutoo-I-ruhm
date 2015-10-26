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
        //postituse uuendamine
        updatePostData($_GET["user_id"], $_GET["postitus"]);
    }
    
    $keyword = "";
    if(isset($_GET["keyword"])){
        $keyword = $_GET["keyword"];
    
    $post_array = getAllData($keyword);
	
	}else{
		$post_array = getAllData();
		
	}
?>

<h1>Tabel</h1>

<form action="table.php" method="get">
    <input name="keyword" type="search" value="<?=$keyword?>" >
    <input type="submit" value="otsi">
<form>
<br><br>
<table border=1>
<tr>
    <th>id</th>
    <th>kasutaja id</th>
	<th>kasutajanimi</th>
    <th>Postitus</th>
    <th>Kustuta</th>
    <th>Muuda</th>
    <th></th>
</tr>
<?php 
    
    for($i = 0; $i < count($post_array); $i++){
        
        // kasutaja tahab rida muuta
        if(isset($_GET["edit"]) && $_GET["edit"] == $post_array[$i]->id){
            echo "<tr>";
            echo "<form action='table.php' method='get'>";
            // input mida välja ei näidata
            echo "<input type='hidden' name='user_id' value='".$post_array[$i]->id."'>";
            echo "<td>".$post_array[$i]->id."</td>";
            echo "<td>".$post_array[$i]->user_id."</td>";
			echo "<td>".$post_array[$i]->user_username."</td>";
            echo "<td><input name='postitus' value='".$post_array[$i]->postitus."' ></td>";
            echo "<td><input name='update' type='submit'></td>";
            echo "<td><input name='update' type='submit'></td>";
            echo "<td><a href='table.php'>cancel</a></td>";
            echo "</form>";
            echo "</tr>";
        }else{
            // lihtne vaade
            echo "<tr>";
            echo "<td>".$post_array[$i]->id."</td>";
            echo "<td>".$post_array[$i]->user_id."</td>";
			echo "<td>".$post_array[$i]->user_username."</td>";
            echo "<td>".$post_array[$i]->postitus."</td>";
            echo "<td><a href='?delete=".$post_array[$i]->id."'>X</a></td>";
            echo "<td><a href='?edit=".$post_array[$i]->id."'>edit</a></td>";
            echo "<td><a href='edit.php?edit_id=".$post_array[$i]->id."'>edit.php</a></td>";
			echo "</tr>";
            
        }
        
        
        
        
    }
    
?>
</table>