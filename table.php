<?php
	require_once("functions.php");
	
	if(isset($_GET["delete"])) {
		deletePostData($_GET["delete"]);
	}
	
	if(isset($_GET["edit"])){
		editPostData($_GET["car"], $_GET["mileage"], $_GET["cost"], $_GET["description"]);
	}
	
	$keyword = "";
	if(isset($_GET["keyword"])){
		$keyword = $_GET["keyword"];
		
		$car_array = getAllData($keyword);
		
	}else{
		$car_array = getAllData();
	}
	?>
	
	<h1>Tabel</h1>
	<form action="table.php" method="get">
		<input name="keyword" type="search" value="<?=$keyword?>">
		<input type="submit" value="otsi">
	<form>
	<br><br>
	<table border=1>
	<tr>
	<th>id</th>
    <th>kasutaja id</th>
    <th>auto</th>
    <th>läbisõit</th>
    <th>kulu</th>
    <th>kirjeldus</th>
    <th></th>
	</tr>