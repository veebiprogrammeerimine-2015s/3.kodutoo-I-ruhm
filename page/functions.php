<?php
	require_once("../../config_global.php");
	$database = "if15_naaber";
	
	session_start();
	
	function loginUser($email, $hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email FROM users_naaber WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		
		if($stmt->fetch()){
			echo "Kasutaja logis sisse id=".$id_from_db;
			$_SESSION['logged_in_user_id'] = $id_from_db;
            $_SESSION['logged_in_user_email'] = $email_from_db;
			header("Location: data.php");
		}else{
			echo "Vale kasutaja või parool!";
		}
        $stmt->close();
        $mysqli->close();
	}
	
	function createUser($create_user_email, $hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO users_naaber (first_name, last_name, organisation, email, password) VALUES (?,?,?,?,?)");
		$stmt->bind_param ("sssss", $first_name, $last_name, $organisation, $create_user_email, $hash);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
	}
	
	function createNewOrder($text_type, $subject, $target_group, $description, $source, $length, $deadline, $output){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO orders_naaber(user_id, text_type, subject, target_group, description, source, length, deadline, output) VALUES(?,?,?,?,?,?,?,?,?)");
		$stmt->bind_param("isssssiss", $_SESSION['logged_in_user_id'], $text_type, $subject, $target_group, $description, $source, $length, $deadline, $output);
		
		$message = "";
		
		if($stmt->execute()){
            $message = "Edukalt andmebaasi salvestatud!";
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $message;
	}
	
	function getAllData($keyword = ""){
		
		if($keyword == ""){
			$search = "%%";	
		}else{
			$search = "%".$keyword."%";
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, user_id, text_type, subject, target_group, description, source, length, deadline, output FROM orders_naaber WHERE user_id=? AND deleted IS NULL AND (text_type LIKE ? OR subject LIKE ? OR target_group LIKE ? OR description LIKE ? OR source LIKE ? OR length LIKE ? OR deadline LIKE ? OR output LIKE ?)");
		$stmt->bind_param("issssssss", $_SESSION["logged_in_user_id"], $search, $search, $search, $search, $search, $search, $search, $search);
		$stmt->bind_result($id_from_db, $user_id_from_db, $text_type_from_db, $subject_from_db, $target_group_from_db, $description_from_db, $source_from_db, $length_from_db, $deadline_from_db, $output_from_db);
		$stmt->execute();
		
		$array = array();
		
		while($stmt->fetch()){
			
			$order = new Stdclass();
			
			$order->id = $id_from_db;
			$order->user_id = $user_id_from_db;
			$order->text_type = $text_type_from_db;
			$order->subject = $subject_from_db;
			$order->target_group = $target_group_from_db;
			$order->description = $description_from_db;
			$order->source = $source_from_db;
			$order->length = $length_from_db;
			$order->deadline = $deadline_from_db;
			$order->output = $output_from_db;
			
			array_push($array, $order);
		}
		
		return $array;
		
		$stmt->close();
		$mysqli->close();
	}
	
	function getSingleOrderData($id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT text_type, subject, target_group, description, source, length, deadline, output FROM orders_naaber WHERE id=? AND user_id=? AND deleted IS NULL");
		$stmt->bind_param("ii", $id, $_SESSION["logged_in_user_id"]);
		$stmt->bind_result($text_type_from_db, $subject_from_db, $target_group_from_db, $description_from_db, $source_from_db, $length_from_db, $deadline_from_db, $output_from_db);
		$stmt->execute();
		
		$order = new Stdclass();
		
		if($stmt->fetch()){
			$order->text_type = $text_type_from_db;
			$order->subject = $subject_from_db;
			$order->target_group = $target_group_from_db;
			$order->description = $description_from_db;
			$order->source = $source_from_db;
			$order->length = $length_from_db;
			$order->deadline = $deadline_from_db;
			$order->output = $output_from_db;
		}else{
			header("Location: table.php");
		}
		
		$stmt->close();
        $mysqli->close();
        
        return $order;
	}
	
	function updateOrdersData($orders_id, $text_type, $subject, $target_group, $description, $source, $length, $deadline, $output){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE orders_naaber SET text_type=?, subject=?, target_group=?, description=?, source=?, length=?, deadline=?, output=?, modified=NOW() WHERE id=? AND user_id=?");
		$stmt->bind_param("sssssissii", $text_type, $subject, $target_group, $description, $source, $length, $deadline, $output, $orders_id, $_SESSION["logged_in_user_id"]);
		$stmt->execute();
		
		header("Location:table.php");
		
		$stmt->close();
		$mysqli->close();
	}
	
	function deleteOrdersData($orders_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE orders_naaber SET deleted=NOW() WHERE id=? AND user_id=?");
		$stmt->bind_param("ii", $orders_id, $_SESSION["logged_in_user_id"]);
		$stmt->execute();
		
		header("Location:table.php");
		
		$stmt->close();
		$mysqli->close();
	}
?>