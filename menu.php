<h2>Menu</h2>
<ul>
    <?php 
    // Ükskõik mis lehe puhul näitan linki aga kui on home 
    // leht siis lihtsalt nime
    if(isset($page_file_name) && $page_file_name != "home.php") { ?>
        <li><a href="home.php">Avaleht</a></li>
    <?php } else { ?>
        <li>Avaleht</li>
    <?php } ?>
    
    <?php 
        if(isset($page_file_name) && $page_file_name != "login.php") { 
            echo '<li><a href="login.php">Logi sisse</a></li>';
        } else { 
            echo '<li>Logi sisse</li>';
        } 
   	?>
	
</ul>