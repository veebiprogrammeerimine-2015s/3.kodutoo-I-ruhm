<h3> Menu </h3>
<ul>
<?php
	if($page_file_name != "home.php") {
	echo "<li><a href='home.php'> Avaleht </a></li>";
	} else {
	echo "<li> Avaleht </li>";
	}
	if($page_file_name != "data.php") {
	echo "<li><a href='data.php'> Lisa Q </a></li>";
	} else {
	echo "<li> Lisa Q </li>";
	 } 
	if($page_file_name != "table.php") {
	echo "<li><a href='table.php'> Tabel </a></li>";
	} else {
	echo "<li> Tabel </li>";
	}
	if(!isset($_SESSION['logged_in_user_id'])){
		if($page_file_name != "sisu.php") { 
		echo "<li><a href='sisu.php'> Log In </a></li>";
		} else { 
		echo "<li>Log In</li>";
		}
		if($page_file_name != "create.php") {
		echo "<li><a href='create.php'> Register </a></li>";
		} else {
		echo "<li>Creation</li>";
		}
}
?>
</ul>