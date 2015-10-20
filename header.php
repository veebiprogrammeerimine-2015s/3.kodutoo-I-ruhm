<html>
	<head>
		<title><?php echo $page_title; ?></title>
		<link rel="stylesheet" type="text/css" href="styles/style.css">
		<link rel="stylesheet" media="screen and (min-width: 1023px) and (max-width: 1920px)" href="styles/desktop.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	</head>
	<body>	
	<header>
	<?php 
	require_once("menu.php"); 
	require_once("login.php");		
	?>
	
	<!--Login form start-->
	<div class="loginmenu">
	
	<?php 
		if(!isset($_SESSION['logged_in_user_id'])) {
	?>
	
	<form class="logininput" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
		<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>">
		<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>">
		<input type="submit" name="login" value="Log in">
	</form>	
	<a href="register.php" style="position: absolute; top: 30px; left: 8px;">Pole kasutajat?</a>
	<?php 
		} else { ?>
			Tere, <?=$_SESSION['logged_in_user_email'];?><br> <a href="?logout=1">Logi välja</a>
	<?php } ?>
	</div>
	<!--Login form end-->
	

	
	<!--Error message-->
	<div class="errormsg"><?php echo $email_error; ?> <?php echo $password_error; ?></div>
	
	<!--logo start-->
	<div id="logoback">
		<div class="logo">
			<a href="home.php"><img src="images/logo.png"></a>
		</div>
	</div>
	<!--logo end-->
	
	
	</header>
	<div id="content">
	
	
	
	