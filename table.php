<?php
	$page_title = "User edit";
	$page_file_name = "userpage.php";
	require_once(__DIR__."/functions.php");
	require_once(__DIR__."/user.class.php");
	if(is_null($_SESSION['logged_in_user_id'])){
		session_destroy();
		header("Location: /index.php");
	}
	$userEdit = new userEdit($connection);
	var_dump($_SESSION);
	$userfirstname_error = "";
	$userlastname_error = "";
	$useraddress_error = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["userfirstname"])) {
		$userfirstname_error = "FirstName is required";
		} else {
		$userfirstname = test_input($_POST["userfirstname"]);
		}

		if (empty($_POST["userlastname"])) {
		$userlastname_error = "LastName is required";
		} else {
		$userlastname = test_input($_POST["userlastname"]);
		}

		if (empty($_POST["useraddress"])) {
		$useraddress_error = "Address required";
		} else {
		$useraddress = test_input($_POST["useraddress"]);
		}

		if ($userfirstname_error == "" and $userlastname_error == "" and $useraddress_error==""){
			$response = $userEdit->editUser($userfirstname, $userlastname, $useraddress);

		}
	}
	?>
	<html>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3">
				<h2>Kasutaja muutmine</h2><br><br>
				<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<?php if(isset($response->success)):	 ?>

						<p><?=$response->success->message;?></p>

						<?php	elseif(isset($response->error)): ?>

						<p><?=$response->error->message;?></p>

						<?php	endif; ?>

					<label>Eesnimi</label>
					<input class="form-control" name="userfirstname" type="text" placeholder="Eesnimi"  ><?php echo $userfirstname_error;?><br>
					<label>Perekonnanimi</label>
					<input class="form-control" name="userlastname" type="text" placeholder="Perekonnanimi" > <?php echo $userlastname_error;?> <br>
					<label>Address</label>
					<input class="form-control" name="useraddress" type="text" placeholder="Address"><?php echo $useraddress_error;?> <br>
					<button type="submit" class="btn btn-info btn-block">Sisesta</button>
					<br><br>
				</form>
			</div>
		</div>
	</div>
	</html>
