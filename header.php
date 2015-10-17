<html>
	<head>
		<title><?php echo $page_title; ?></title>
		<link rel="stylesheet" type="text/css" href="styles/style.css">
		<link rel="stylesheet" media="screen and (min-width: 1023px) and (max-width: 1920px)" href="styles/desktop.css">
	</head>
	<body>	
	<header>
	<?php 
	require_once("menu.php"); 
	require_once("login.php");			
	?>
	
		<!--Login form-->
	<div id="login">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
				<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <br><?php echo $email_error; ?>
				<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"><br> <?php echo $password_error; ?>
				<input type="submit" name="login" value="Log in">
			</form>
			<a href="register.php">Pole kasutajat?</a>
	</div>
	<!--Login form end-->
	
	<!--logo start-->
	<div id="logoback">
		<div class="logo">
			<a href="home.php"><img src="images/logo.png"></a>
		</div>
	</div>
	<!--logo end-->
	
	
	</header>
	<div id="content">
	
	
	
	