<?php
	require_once("functions.php");
	
	if(!isSet($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}

	if(isSet($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
	}
	
	$text_type = $subject = $target_group = $description = $source = $length = $deadline = $output = $m = "";
	$text_type_error = $subject_error = $target_group_error = $description_error = $source_error = $length_error = $deadline_error_1 = $deadline_error_2 = $output_error = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		if(isSet($_POST["add_new_order"])){
			
			if(empty($_POST["text_type"])){
				$text_type_error = "Teksti tüüp on kohustuslik";
			}else{
				$text_type = cleanInput($_POST["text_type"]);
			}
			
			if(empty($_POST["subject"])){
				$subject_error = "Teema on kohustuslik";
			}else{
				$subject = cleanInput($_POST["subject"]);
			}
			
			if(empty($_POST["target_group"])){
				$target_group_error = "Sihtgrupp on kohustuslik";
			}else{
				$target_group = cleanInput($_POST["target_group"]);
			}
			
			if(empty($_POST["description"])){
				$description_error = "Kirjeldus on kohustuslik";
			}else{
				$description = cleanInput($_POST["description"]);
			}
			
			if(empty($_POST["source"])){
				$source_error = "Allikas on kohustuslik";
			}else{
				$source = cleanInput($_POST["source"]);
			}
			
			if(empty($_POST["length"])){
				$length_error = "Maht on kohustuslik";
			}else{
				$length = cleanInput($_POST["length"]);
			}
			
			if(empty($_POST["deadline"])){
				$deadline_error_1 = "Tähtaeg on kohustuslik";
			}else{
				if($_POST["deadline"] < date("Y-m-d H:i:s")){
					$deadline_error_2 = "Kuupäev peab olema tulevikus";
				}else{
					$deadline = cleanInput($_POST["deadline"]);
				}
			}
			
			if(empty($_POST["output"])){
				$output_error = "Ilmumiskoht on kohustuslik";
			}else{
				$output = cleanInput($_POST["output"]);
			}
			
			if ($text_type_error == "" && $subject_error == "" && $target_group_error == "" && $description_error == "" && $source_error == "" && $length_error == "" && $deadline_error_1 == "" && $deadline_error_2 == "" && $output_error == ""){
				$m = createNewOrder($text_type, $subject, $target_group, $description, $source, $length, $deadline, $output);
				if($m != ""){
					$text_type = "";
					$subject = "";
					$target_group = "";
					$description = "";
					$source = ""; 
					$length = "";
					$deadline = "";
					$output = "";
				}
			}
		}
	}
	
	function cleanInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
	}
	
?>

Kasutaja: <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1" style="text-decoration:none">[logi välja]</a>

<h2>Tellimuse esitamine</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<select id="text_type" name="text_type">
		<option value="">[ Teksti tüüp ]</option>
		<option value="uudislugu"<?=$text_type == "uudislugu" ? "selected='selected'" : ""?>>Uudislugu</option>
		<option value="pressiteade"<?=$text_type == "pressiteade" ? "selected='selected'" : ""?>>Pressiteade</option>
		<option value="reklaamtekst"<?=$text_type == "reklaamtekst" ? "selected='selected'" : ""?>>Reklaamtekst</option>
		<option value="blogipostitus"<?=$text_type == "blogipostitus" ? "selected='selected'" : ""?>>Blogipostitus</option>
		<option value="uudiskiri"<?=$text_type == "uudiskiri" ? "selected='selected'" : ""?>>Uudiskiri</option>
	</select>* <?=$text_type_error;?><br><br>
	<input id="subject" name="subject" type="text" placeholder="Teema" value="<?=$subject;?>">* <?=$subject_error;?><br><br>
	<input id="target_group" name="target_group" type="text" placeholder="Sihtgrupp" value="<?=$target_group;?>">* <?=$target_group_error;?><br><br>
	<textarea style="resize:none" id="description" name="description" rows="10" cols="28" placeholder="Kirjeldus"><?=$description;?></textarea>* <?=$description_error;?><br><br>
	<input id="source" name="source" type="text" placeholder="Allikas" value="<?=$source;?>">* <?=$source_error;?><br><br>
	<input id="length" name="length" type="number" placeholder="Maht (tähemärgid)" value="<?=$length;?>">* <?=$length_error;?><br><br>
	<input id="deadline" name="deadline" type="datetime-local" value="<?=$deadline;?>">* <?=$deadline_error_1;?><?=$deadline_error_2;?><br><br>
	<input id="output" name="output" type="text" placeholder="Ilmumiskoht" value="<?=$output;?>">* <?=$output_error;?><br><br>
	<input name="add_new_order" type="submit" value="Lisa uus tellimus">
	<p style="color:green;"><?=$m;?></p>
</form>

<a href="table.php">Tellimuste tabel</a>