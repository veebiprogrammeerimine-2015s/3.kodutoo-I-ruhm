<h3>Menu</h3>
<ul>
	<?php if($page_file_name != "home.php") {?>
	<li><a href="home.php">Avaleht</a></li>
	<?php } else { ?>
		<li>Avaleht</li>
	<?php } ?>
	
	<?php if($page_file_name != "login.php") {?>
	<li><a href="login.php">Login</a></li>
	<?php } else { ?>
		<li>Login</li>
	<?php } ?>
	
	<?php if($page_file_name != "data.php") {?>
	<li><a href="data.php">Data</a></li>
	<?php } else { ?>
		<li>Data</li>
	<?php } ?>
	
	<?php if($page_file_name != "table.php") {?>
	<li><a href="table.php">Tabel</a></li>
	<?php } else { ?>
		<li>Tabel</li>
	<?php } ?>
</ul>