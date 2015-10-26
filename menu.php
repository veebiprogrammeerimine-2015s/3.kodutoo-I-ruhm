<h3>Menüü</h3>
<ul>
	<?php 
	//Ükskõik mis lehe puhul näitan linki, aga kui on "home"
	//leht, siis lihtsalt nime
	if($page_file != "home.php"){ ?>
		<li><a href="home.php">Avaleht</a></li>
	<?php } else { ?>
		<li>Avaleht</li>
	<?php } ?>
	<?php 
	if($page_file != "login.php"){ ?>
		<li><a href="login.php">Logi sisse</a></li>
	<?php } else { ?>
		<li>Logi sisse</li>
	<?php } ?>
	<?php 
	if($page_file != "create_user.php"){ ?>
		<li><a href="create_user.php">Loo kasutaja</a></li>
	<?php } else { ?>
		<li>Loo kasutaja</li>
	<?php } ?>
</ul>