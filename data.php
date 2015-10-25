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
    
    
    // muutujad väärtustega
    $prillivarv = $materjal = $m = "";
    $prillivarv_error = $materjal_error = "";
    //echo $_SESSION['logged_in_user_id'];
    
    // valideerida välja ja käivita fn
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if(isset($_POST["add_evo_glasses"])){
            
            if ( empty($_POST["prillivarv"]) ) {
                $prillivarv_error = "Prillivärv on kohustuslik!";
            }else{
                $prillivarv = cleanInput($_POST["prillivarv"]);
            }
            
            if ( empty($_POST["materjal"]) ) {
                $materjal_error = "Auto värv on kohustuslik!";
            }else{
                $materjal = cleanInput($_POST["materjal"]);
            }
            
            //erroreid ei olnud käivitan funktsiooni,
            //mis sisestab andmebaasi
            if($prillivarv_error == "" && $materjal_error == ""){
                // m on message mille saadame functions.php
                $m = newGlasses($prillivarv, $materjal);
                
                if($m != ""){
                    // teeme vormi tühjaks
                    $prillivarv = "";
                    $materjal = "";
                }
            }
            
        }
    }
    
    
    // kirjuta fn 
    function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    
    // küsime tabeli kujul andmed
    getAllData();
    
    
?>

Tere, <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1">Logi välja</a>

<h2>Lisa uued Prillid</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <label for="prillivarv"> prillivarv </label>
  	<input id="prillivarv" name="prillivarv" type="text" value="<?=$prillivarv;?>"> <?=$prillivarv_error;?><br><br>
  	<label for="materjal"> materjal </label>
    <input id="materjal" name="materjal" type="text" value="<?=$materjal;?>"> <?=$materjal_error;?><br><br>
  	<input type="submit" name="add_evo_glasses" value="Lisa">
    <p style="color:green;"><?=$m;?></p>
  </form>