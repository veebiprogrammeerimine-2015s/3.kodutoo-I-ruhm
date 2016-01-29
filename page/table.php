<?php
require_once("../functions.php");

$tex_array = getAllData();
if(isset($_GET["delete"])) {
        deleteQweetData($_GET["delete"], $_GET["user"]);
    }

if(isset($_GET["update"])){
        updateQweetData($_GET["qwert"], $_GET["qwert_id"], $_GET["user_id"]);
    }
    
	$keyword = "";
    if(isset($_GET["keyword"])){
        $keyword = $_GET["keyword"];
        $tex_array = getAllData($keyword);
        
        
    }else{
	$tex_array = getAllData();
        
    }
	if(isset($_GET["logout"])){
        //kustutame sessiooni muutujad
        session_destroy();
        header("Location: sisu.php");
    }
if(isset($_SESSION['logged_in_user_id'])){
		echo "Tere, ",$_SESSION['logged_in_user_email'], "<a href='?logout=1'> Logi välja</a>";
		
}
?>
<?php 
	$page_title = "Qweedid";
	$page_file_name = "tabel.php";
	
require_once("../header.php"); ?>



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
    <th></th>
    <th></th>
</tr>
<?php 
for($i = 0; $i < count($tex_array); $i++){
if(isset($_SESSION['logged_in_user_id'])&& $_SESSION['logged_in_user_id']==$tex_array[$i]->user_id){	
	if(isset($_GET["edit"]) && $_GET["edit"] == $tex_array[$i]->id) {
		echo "<tr>";
        echo "<form action='table.php' method='get'>";
		echo "<input type='hidden' name='qwert_id' value='".$tex_array[$i]->id."'>";
		echo "<input type='hidden' name='user_id' value='".$_SESSION['logged_in_user_id']."'>";
		echo "<td>".$tex_array[$i]->id."</td> ";
		echo "<td>".$tex_array[$i]->user_id."</td> ";
		echo "<td><input name='qwert' value='".$tex_array[$i]->qwert."'></td>";
		echo "<td><input name='update' type='submit'></td>";
		echo "<td><a href='table.php'>cancel</a></td>";
		echo "</form>";
    }
	else{
		echo "<form action='table.php' method='get'>";
		echo "<tr> <td>".$tex_array[$i]->id."</td> ";
		echo "<td>".$tex_array[$i]->user_id."</td> ";
		echo "<td>".$tex_array[$i]->qwert."</td>"; 
		echo "<td><a href='?delete=".$tex_array[$i]->id."'>X</a></td>";
		echo "<td><a href='?edit=".$tex_array[$i]->id."'>Edit</a></td></tr>";
		echo "</form>";
	}
} else {
	echo "<tr> <td>".$tex_array[$i]->id."</td> ";
	echo "<td>".$tex_array[$i]->user_id."</td> ";
	echo "<td>".$tex_array[$i]->qwert."</td></tr>";
}
}
?>
</table>

<?php require_once("../footer.php"); ?>
