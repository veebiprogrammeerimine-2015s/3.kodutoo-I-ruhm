<html>
		<head>
			<?php $page_title = "Home";
			$page_file_name = "home.php";
			require_once("../header.php");
			?>
			
			<Title><?php echo $page_title?></title>
		</head>
		<?$_SESSION['logged_in_user_email'])?> <a href="?logout=1">Logi välja</a>
		
<p>Avaleht</p>
<?php require_once("../footer.php");
	

	if(isset($_GET["logout"])){
			//kustutame sessiooni muutujad
			session_destroy();
			header("Location: login.php");
	}
 ?>