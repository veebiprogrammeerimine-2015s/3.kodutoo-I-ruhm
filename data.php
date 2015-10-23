<?php
    // kõik mis seotud andmetabeliga, lisamine ja tabeli kujul esitamine
    require_once("functions.php");
    
    //kui kasutaja ei ole sisse logitud, suuna teisele lehele
    //kontrollin kas sessiooni muutuja olemas
    if(!isset($_SESSION['logged_in_user_id'])){
        header("Location: login.php");
    }
    
    // aadressireale tekkis ?logout=1
    if(isset($_GET["logout"])){
        //kustutame sessiooni muutujad
        session_destroy();
        header("Location: login.php");
    }
	
	$qweet = "";
	$qweet_error = "";
	$m = "";
	
		
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST["create_qweet"])){
			if ( empty($_POST["qweet"]) ) {
				$qweet_error = "See väli on kohustuslik";
			}else{
				$qweet = cleanInput($_POST["qweet"]);
			}
	 }
		if($qweet_error == ""){
			$m = create_qweet($qweet);
			
			if($m != ""){
				$qweet = "";
			}
		}
	}
function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
  
  getAllData();
?>

<nav id="menyy">
<ul>
  <li><a href="table.php" target="_self">Suured qweedid</a></li>
</ul>
</nav>


Tere, <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1"> Logi välja</a>

<h2> Lisa uus qweet </h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
<label for="qweet"> Sinu Qweet </label>
  	<input id="qweet" name="qweet" type="text" value="<?=$qweet; ?>"> <?=$qweet_error; ?><br>
	<? echo $qweet?><br>
	<input type="submit" name="create_qweet" value="Qweet">
	<p style="color:green;"> <?=$m?> </p>
  </form>