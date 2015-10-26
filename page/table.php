<?php
	require_once("functions.php");
	
	if(!isSet($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	if(isSet($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
	}
	
	$keyword = "";
	
	if(isset($_GET["keyword"])){
		$keyword = $_GET["keyword"];
		$orders_array = getAllData($keyword);
	}else{
		$orders_array = getAllData();
	}
	
	if(isset($_GET["update"])){
		updateOrdersData(cleanInput($_GET["orders_id"]), cleanInput($_GET["text_type"]), cleanInput($_GET["subject"]), cleanInput($_GET["target_group"]), cleanInput($_GET["description"]), cleanInput($_GET["source"]), cleanInput($_GET["length"]), cleanInput($_GET["deadline"]), cleanInput($_GET["output"]));
	}
	
	if(isset($_GET["delete"])){
		deleteOrdersData($_GET["delete"]);
	}
	
	function cleanInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
	}
	
?>

Kasutaja: <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1" style="text-decoration:none">[logi välja]</a>

<h2>Tellimuste tabel</h2>

<form action="table.php" method="get">
	<input name="keyword" type="search" value="<?=$keyword?>">
	<input type="submit" value="otsi">
</form>

<table border=1>
<tr>
    <th>teksti tüüp</th>
    <th>teema</th>
	<th>sihtgrupp</th>
    <th>kirjeldus</th>
    <th>allikad</th>
    <th>maht</th>
    <th>tähtaeg</th>
	<th>ilmumiskoht</th>
    <th></th>
	<th></th>
</tr>

<?php
	for($i = 0; $i < count($orders_array); $i++){
		echo "<tr>";
		echo "<td>".$orders_array[$i]->text_type."</td>";
		echo "<td>".$orders_array[$i]->subject."</td>";
		echo "<td>".$orders_array[$i]->target_group."</td>";
		echo "<td>".$orders_array[$i]->description."</td>";
		echo "<td>".$orders_array[$i]->source."</td>";
		echo "<td>".$orders_array[$i]->length."</td>";
		echo "<td>".$orders_array[$i]->deadline."</td>";
		echo "<td>".$orders_array[$i]->output."</td>";
		echo "<td><a href='?delete=".$orders_array[$i]->id."'>kustuta</a></td>";
		echo "<td><a href='edit.php?edit_id=".$orders_array[$i]->id."'>muuda</a></td>";
		echo "<tr>";
	}
?>
</table><br>

<a href="data.php">Tellimuse esitamine</a>