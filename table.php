<html>
<?php
require_once("functions.php");

$tex_array = getAllData();
if(isset($_GET["delete"])) {
        ///saadan kustutatava auto id
        deleteQweetData($_GET["delete"]);
    }

 if(isset($_GET["update"])){
        updateQweetData($_GET["qwert"], $_GET["qwert_id"]);
    }
    
	$keyword = "";
    if(isset($_GET["keyword"])){
        $keyword = $_GET["keyword"];
        
        // otsime 
        $tex_array = getAllData($keyword);
        
        
    }else{
	$tex_array = getAllData();
        
    }
?>

<nav id="menyy">
<ul>
  <li><a href="data.php" target="_self">Loo Qweet</a></li>
</ul>
</nav>
<br><br>

<h1> Qweedid </h1>
<form action="table.php" method="get">
    <input name="keyword" type="search" value="<?=$keyword?>" >
    <input type="submit" value="otsi">
<form>
<br><br>
<table border=1>
<tr>
    <th>id</th>
    <th>kasutaja id</th>
    <th>auto numbrimärk</th>
    <th></th>
    <th></th>
</tr>
<?php 
for($i = 0; $i < count($tex_array); $i++){
	
	if(isset($_GET["edit"]) && $_GET["edit"] == $tex_array[$i]->id) {
		echo "<tr>";
        echo "<form action='table.php' method='get'>";
		echo "<input type='hidden' name='qwert_id' value='".$tex_array[$i]->id."'>";
		echo "<td>".$tex_array[$i]->id."</td> ";
		echo "<td>".$tex_array[$i]->user_id."</td> ";
		echo "<td><input name='qwert' value='".$tex_array[$i]->qwert."'></td>";
		echo "<td><input name='update' type='submit'></td>";
		echo "<td><a href='table.php'>cancel</a></td>";
    }
	else{
		echo "<tr> <td>".$tex_array[$i]->id."</td> ";
		echo "<td>".$tex_array[$i]->user_id."</td> ";
		echo "<td>".$tex_array[$i]->qwert."</td>"; 
		echo "<td><a href='?delete=".$tex_array[$i]->id."'>X</a></td>";
		echo "<td><a href='?edit=".$tex_array[$i]->id."'>Edit</a></td></tr>";
	
	} 
}

?>
</table>
</html>