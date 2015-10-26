<h3>Menüü</h3>
<?php
	//lehe name
	$page_title="Kasside hoiukodu";
	
	//faili name
	$page_file_name="menu.php";
?>
<ul>
	<?php
	// ükskõik mis lehe puhul näitan linki aga kui on home leht siis nime
	if($page_file_name != "home.php") { ?>
	<li><a href="home.php">Avaleht</a></li>
	<?php } else {  ?>
		<li> Avaleht </li>
	<?php } ?>
	
	<?php
	// ükskõik mis lehe puhul näitan linki aga kui on home leht siis nime
	if($page_file_name != "leidnud.php") { ?>
	<li><a href="leidnud.php">Kodu leidnud kassid</a></li>
	<?php } else {  ?>
		<li> Kodu leidnud kassid </li>
	<?php } ?>
	
	<?php
	// ükskõik mis lehe puhul näitan linki aga kui on home leht siis nime
	if($page_file_name != "otsivad.php") { ?>
	<li><a href="otsivad.php">Kodu otsivad kassid</a></li>
	<?php } else {  ?>
		<li> Kodu otsivad kassid </li>
	<?php } ?>
	
</ul>