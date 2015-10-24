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
	}
}
?>
<h1>Tööpakkumised</h1>

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
		//kõik tööd objektide kujul massiivis
		$job_array = getAllData();
		//tööd ükshaaval läbi käia
		for($i = 0; $i < count($job_array); $i++) {
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
					echo "<td><a href='?delete=".$job_array[$i]->id."'>x</a></td>";
				}
			}
			echo "</tr>";
		}
	?>
</table>