<h3>Menüü</h3>
<ul>
    <?php 
    // Ükskõik mis lehe puhul näitan linki aga kui on home 
    // leht siis lihtsalt nime
    if($page_file_name != "home.php") { ?>
        <li><a href="home.php">Avaleht</a></li>
    <?php } else { ?>
        <li>Avaleht</li>
    <?php } ?>
    
    <?php 
        if($page_file_name != "login.php") { 
            echo '<li><a href="login.php">Logi sisse</a></li>';
        } else { 
            echo '<li>Logi sisse</li>';
        } 
    ?>
</ul>