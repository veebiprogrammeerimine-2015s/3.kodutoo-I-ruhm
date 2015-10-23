<?php  
require_once("functions.php");

if(isset($_GET["delete"])) {
	deleteNote($_GET["delete"]);
}

$note_array = getAllData();

$keyword = "";
if(isset($_GET["keyword"])){
	$keyword = $_GET["keyword"];
	
	$note_array = getSearchData($keyword);	
}else{
	$note_array = getAllData();
}
?>

<h1>Table</h1>
<form action="table.php" action="get">
	<input name="keyword" type="search" value="<?=$keyword?>" > 
	<input type="submit" value="Search">
</form>
<table border=1>
<tr>
    <th>N-ID</th>
    <th>U-ID</th>
    <th>Note</th>
    <th>Completed?</th>
    <th>Del</th>
    <th>Edit</th>
</tr>
<?php 

for($i = 0; $i < count($note_array); $i++){
	
	if(isset($_GET["edit"]) && $_GET["edit"] == $note_array[$i]->id){
		echo "<tr>";
		echo "<form action='table.php' method='get'>";
		echo "<input type='hidden' name='note_id' value='".$note_array[$i]->id."'>";
		echo "<td>".$note_array[$i]->id."</td>";
		echo "<td>".$note_array[$i]->user_id."</td>";
		echo "<td><input name='note' value='".$note_array[$i]->note."' ></td>";
		echo "<td><input name='done' value='".$note_array[$i]->done."' ></td>";
		echo "<td><input name='update' type='submit'></td>";
		echo "<td><a href='table.php'>cancel</a></td>";
		echo "</form>";
		echo "</tr>";
	}else{
		echo "<tr>";
		echo "<td>".$note_array[$i]->id."</td>";
		echo "<td>".$note_array[$i]->user_id."</td>";
		echo "<td>".$note_array[$i]->note."</td>";
		echo "<td>".$note_array[$i]->done."</td>";
		echo "<td><a href='?delete=".$note_array[$i]->id."'>X</a></td>";
		echo "<td><a href='edit.php?edit_id=".$note_array[$i]->id."'>edit.php</a></td>";
		echo "</tr>";
		
	}   
}
?>
</table>	