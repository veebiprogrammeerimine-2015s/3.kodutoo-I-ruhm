<?php
	require_once("functions.php");
	
	if(!isSet($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	if(isSet($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
	}
	
	if(isset($_GET["update"])){
		updateOrdersData(cleanInput($_GET["orders_id"]), cleanInput($_GET["text_type"]), cleanInput($_GET["subject"]), cleanInput($_GET["target_group"]), cleanInput($_GET["description"]), cleanInput($_GET["source"]), cleanInput($_GET["length"]), cleanInput($_GET["deadline"]), cleanInput($_GET["output"]));
	}
	
	if(isset($_GET["edit_id"])){
		$order = getSingleOrderData($_GET["edit_id"]);
	}else{
		header("Location: table.php");
	}
	
	function cleanInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
	}
?>

Kasutaja: <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1" style="text-decoration:none">[logi välja]</a>

<h2>Tellimuse muutmine</h2>

<form action="edit.php" method="get">
	<input type="hidden" name="orders_id" value="<?=$_GET["edit_id"];?>">
	<select name="text_type">
		<option value="uudislugu"<?=$order->text_type == "uudislugu" ? "selected='selected'" : ""?>>Uudislugu</option>
		<option value="pressiteade"<?=$order->text_type == "pressiteade" ? "selected='selected'" : ""?>>Pressiteade</option>
		<option value="reklaamtekst"<?=$order->text_type == "reklaamtekst" ? "selected='selected'" : ""?>>Reklaamtekst</option>
		<option value="blogipostitus"<?=$order->text_type == "blogipostitus" ? "selected='selected'" : ""?>>Blogipostitus</option>
		<option value="uudiskiri"<?=$order->text_type == "uudiskiri" ? "selected='selected'" : ""?>>Uudiskiri</option>
	</select><br><br>
	<input name="subject" type="text" value="<?=$order->subject;?>"><br><br>
	<input name="target_group" type="text" value="<?=$order->target_group;?>"><br><br>
	<textarea style="resize:none" name="description" rows="10" cols="28"><?=$order->description;?></textarea><br><br>
	<input name="source" type="text" value="<?=$order->source;?>"><br><br>
	<input name="length" type="number" value="<?=$order->length;?>"><br><br>
	<input name="deadline" type="datetime" value="<?=$order->deadline;?>"><br><br>
	<input name="output" type="text" value="<?=$order->output;?>"><br><br>
	<input name="update" type="submit" value="Muuda tellimus">
</form>
<a href="table.php" style="text-decoration:none">
	<input type="button" value="Tühista"/>
</a>