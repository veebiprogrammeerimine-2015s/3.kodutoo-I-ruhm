<?php
	//Lehe nimi
	$page_title = "Tööpakkumised";
	//Faili nimi
	$page_file = "jobs.php";
?>
<?php
	require_once("header.php"); 
	require_once ("functions.php");
?>
<?php
	if(isset($_SESSION['logged_in_user_id'])) {
		if($_SESSION['logged_in_user_group'] == 3) {
			if(isset($_GET["delete"])) {
				//saadan kustutatava töö id
				deleteJobData($_GET["delete"]);
			}
			if(isset($_GET["update"])) {
				updateJobData($_GET["job_id"], $_GET["job_name"], $_GET["job_desc"], $_GET["job_company"], $_GET["job_county"], $_GET["job_parish"], $_GET["job_location"], $_GET["job_address"]);
			}
		}
	}

		//kõik tööd objektide kujul massiivis
		$job_array = getAllData();
	
	$keyword = "";
	if (isset($_GET["keyword"])) {
		$keyword = $_GET["keyword"];
	
		//otsime
		$job_array = getAllData($keyword);
	} else {
		//Naitame koiki tulemus
		$job_array = getAllData();
	}
?>
<h1>Tööpakkumised</h1>
<form action="jobs.php" method="get">
	<input name="keyword" type="search" value="<?=$keyword?>">
	<input type="submit" value="otsi">
</form>
<table border=1>
	<tr>
	<th>Amet</th>
	<th>Kirjeldus</th>
	<th>Asutus</th>
	<th>Maakond</th>
	<th>Vald</th>
	<th>Asula</th>
	<th>Aadress</th>
	</tr>

	<?php

		//tööd ükshaaval läbi käia
		for($i = 0; $i < count($job_array); $i++) {
		if(isset($_GET["edit"]) && $_GET["edit"] == $job_array[$i]->id) {
			echo "<tr>";
			echo "<form action='jobs.php' method='get'>";
			//Peidetud input
			echo "<input type='hidden' name='job_id' value='".$job_array[$i]->id."'>";
			echo "<td><input name='job_name' value='".$job_array[$i]->name."'></td>";
			echo "<td><input name='job_desc' value='".$job_array[$i]->description."'></td>";
			echo "<td><input name='job_company' value='".$job_array[$i]->company."'></td>";
			echo "<td><input name='job_county' value='".$job_array[$i]->county."'></td>";
			echo "<td><input name='job_parish' value='".$job_array[$i]->parish."'></td>";
			echo "<td><input name='job_location' value='".$job_array[$i]->location."'></td>";
			echo "<td><input name='job_address' value='".$job_array[$i]->address."'></td>";
			echo "<td><a href='jobs.php'>Cancel</a></td>";
			echo "<td><input name='update' type='submit'</input></td>";
			echo "</form>";
			echo "</tr>";
		} else {
			echo "<tr>";
			echo "<td>".$job_array[$i]->name."</td>";
			echo "<td>".$job_array[$i]->description."</td>";
			echo "<td>".$job_array[$i]->company."</td>";
			echo "<td>".$job_array[$i]->county."</td>";
			echo "<td>".$job_array[$i]->parish."</td>";
			echo "<td>".$job_array[$i]->location."</td>";
			echo "<td>".$job_array[$i]->address."</td>";
			if(isset($_SESSION['logged_in_user_id'])) {
				if($_SESSION['logged_in_user_group'] == 3) {
					echo "<td><a href='?edit=".$job_array[$i]->id."'>muuda</a></td>";
					echo "<td><a href='?delete=".$job_array[$i]->id."'>x</a></td>";
				}
				}
			}
			echo "</tr>";
		}
	?>
</table>

<?php require_once("footer.php"); ?>