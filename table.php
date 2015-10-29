<?php  
    require_once("functions.php");
    
    
    // kuulan, kas kasutaja tahab kustutada
    // ?delete=... on aadressireal
    if(isset($_GET["delete"])) {
        ///saadan kustutatava posti id
		if(isset($_SESSION['logged_in_user_id'])){
		
		deletePostData($_GET["delete"]);
		}
    }
    
    //Kasutaja muudab andmeid
    if(isset($_GET["update"])){
        //postituse uuendamine
		if(isset($_SESSION['logged_in_user_id'])){
			updatePostData($_GET["user_id"], $_GET["postitus"]);
		}
    }
    
	
	if(isset($_GET["logout"])){
        session_destroy();
        header("Location: table.php");
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
	<th>kasutajanimi</th>
    <th>Postitus</th>

<?php if (isset($_SESSION['logged_in_user_id']) && $post_array[$i]->user_id == $_SESSION['logged_in_user_id']){ ?>
	<th>Kustuta</th>
	<th>Muuda</th>

<?php } ?>
	
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
			echo "<td>".$post_array[$i]->user_username."</td>";
            echo "<td><input name='postitus' value='".$post_array[$i]->postitus."' ></td>";
            echo "<td><input name='update' type='submit'></td>";
            echo "<td><a href='table.php'>cancel</a></td>";
            echo "</form>";
            echo "</tr>";
        }else{
            // lihtne vaade
            echo "<tr>";
            echo "<td>".$post_array[$i]->id."</td>";
			echo "<td>".$post_array[$i]->user_username."</td>";
            echo "<td>".$post_array[$i]->postitus."</td>";
			
			if (isset($_SESSION['logged_in_user_id']) && $post_array[$i]->user_id == $_SESSION['logged_in_user_id']){
				echo "<td><a href='?delete=".$post_array[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$post_array[$i]->id."'>edit</a></td>";
			}
			
            
			//echo "<td><a href='edit.php?edit_id=".$post_array[$i]->id."'>edit.php</a></td>";
			echo "</tr>";
            
        }
        
    }
    
?>
</table>