<?php
    // kıik mis seotud andmetabeliga, lisamine ja tabeli kujul esitamine
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
	
	
    // muutujad v‰‰rtustega
    $postitus = $m = "";
    $postitus_error = "";
    //echo $_SESSION['logged_in_user_id'];
    
    // valideerida v‰lja ja k‰ivita fn
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if(isset($_POST["add_postitus"])){
            
            if ( empty($_POST["postitus"]) ) {
                $postitus_error = "Postituse sisu on kohustuslik!";
            }else{
                $postitus = cleanInput($_POST["postitus"]);
            }
            
            
            //erroreid ei olnud k‰ivitan funktsiooni,
            //mis sisestab andmebaasi
            if($postitus_error == ""){
                // m on message mille saadame functions.php
                $m = createNewPost($postitus);
                
                if($m != ""){
                    // teeme vormi t¸hjaks
                    $postitus = "";
                    
                }
            }
         header( "Refresh:3; url=table.php", true, 303);
		 
        }
    }
    
    
    // kirjuta fn 
    function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    
    // k¸sime tabeli kujul andmed
    getAllData();
    
    
?>

Tere, <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1">Logi v√§lja</a>

<h2>Lisa uus postitus</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <label for="postitus"> Postitus </label>
  	<input id="postitus" name="postitus" type="text" value="<?=$postitus;?>"> <?=$postitus_error;?><br><br>
  	<input type="submit" name="add_postitus" value="Lisa">
    <p style="color:green;"><?=$m;?></p>
  </form>
 
<?php
if($page_file_name = "data.php") {
		echo '<a href="table.php">N√§ita k√µiki postitusi</a>';

	}
?>