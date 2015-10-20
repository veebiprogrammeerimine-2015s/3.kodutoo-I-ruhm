<?php
	require_once("functions.php");
	
	if(isset($_GET["delete"])) {
		deletePostData($_GET["delete"]);
	}
	
	if(isset($_GET["edit"])){
		editPostData($_GET["car"], $_GET["mileage"], $_GET["cost"], $_GET["description"]);
	}