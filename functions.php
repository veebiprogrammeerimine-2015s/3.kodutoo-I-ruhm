<?php


	require_once("../../config_global.php");
	$database = "if15_karl";
	
	function getAllData($keyword=""){
		
		if($keyword == ""){
			$search = "%%";
		}else{
			$search = "%".$keyword."%";
		}
		
		
	}
	
	
	
	
?>