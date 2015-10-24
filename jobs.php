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
		//kõik autod objektide kujul massiivis
		$job_array = getAllData();
		//autod ükshaaval läbi käia
		for($i = 0; $i < count($job_array); $i++) {
			echo "<tr>";
			echo "<td>".$job_array[$i]->name."</td>";
			echo "<td>".$job_array[$i]->description."</td>";
			echo "<td>".$job_array[$i]->company."</td>";
			echo "<td>".$job_array[$i]->county."</td>";
			echo "<td>".$job_array[$i]->parish."</td>";
			echo "<td>".$job_array[$i]->location."</td>";
			echo "<td>".$job_array[$i]->address."</td>";
			echo "</tr>";
		}
	?>
</table>