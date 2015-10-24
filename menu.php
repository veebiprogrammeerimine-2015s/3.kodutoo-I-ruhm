
<nav>
<ul>
	<?php if($page_file != "home.php") { ?>
		<a href="home.php">Avaleht</a> |
	<?php } else { ?>
		Avaleht |
	<?php } ?>
	
	<?php if($page_file != "jobs.php") { ?>
		<a href="jobs.php">Tööpakkumised</a> |
	<?php } else { ?>
		Tööpakkumised |
	<?php } ?>
	
	<?php if($page_file != "data.php") { ?>
		<a href="data.php">Data</a> |
	<?php } else { ?>
		Data |
	<?php } ?>
	
	
</ul>
</nav>