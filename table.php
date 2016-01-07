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
	$getAllUsers = new getAllUsers($connection);
	$deleteUsers = new deleteUsers($connection);
	$updateUsers = new updateUsers($connection);

	$users_array = $getAllUsers->getAllUsers();
	if(isset($_GET["delete"])) {
		$response = $deleteUsers->deleteUsers($_GET["delete"]);
	}

	if(isset($_GET["update"])){
		$response = $updateUsers->updateUsers($_GET['first_name'], $_GET['last_name'], $_GET['address'], $_GET['creation_date'], $_GET['privileges'], $_GET['user_id']);
	}

	$keyword = "";
	if(isset($_GET["keyword"])){
		$keyword = $_GET["keyword"];
		$users_array = $getAllUsers->getAllUsers($keyword);
	}else{
		$users_array = $getAllUsers->getAllUsers();
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
	<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9">
			<table class="table table-hover">
				<tr>
					<th>Kasutaja ID</th>
					<th>Kasutajanimi</th>
					<th>Eesnimi</th>
					<th>Perekonnanimi</th>
					<th>Aadress</th>
					<th>Kasutaja loomise kuupäev</th>
					<th>Õigused</th>
					<th>Muuda</th>
					<th>Kustuta</th>
				</tr>
				<?php
				for($i = 0; $i < count($users_array); $i++){
					if(isset($_GET["edit"]) && $_GET["edit"] == $users_array[$i]->id) {
						echo "<tr>";
						echo '<form action="/table.php" method="get">';
						echo "<input type='hidden' name='user_id' value='".$users_array[$i]->id."'>";
						echo "<td>".$users_array[$i]->id."</td> ";
						echo "<td><input class='form-control' name='username' value='".$users_array[$i]->username."'></td>";
						echo "<td><input class='form-control' name='first_name' value='".$users_array[$i]->first_name."'></td>";
						echo "<td><input class='form-control' name='last_name' value='".$users_array[$i]->last_name."'></td>";
						echo "<td><input class='form-control' name='address' value='".$users_array[$i]->address."'></td>";
						echo "<td><input class='form-control' name='creation_date' value='".$users_array[$i]->creation_date."'></td>";
						echo "<td><input class='form-control' name='privileges' value='".$users_array[$i]->privileges."'></td>";
						echo "<td><input class='btn btn-default btn-block' name='update' type='submit' value='Uuenda'></td>";
						echo "<td><a class='btn btn-default btn-block' href='/table.php'>Katkesta</a></td>";
						echo "</tr>";
						echo "</form>";
					} else {
						echo "<tr> <td>".$users_array[$i]->id."</td> ";
						echo "<td>".$users_array[$i]->username."</td>";
						echo "<td>".$users_array[$i]->first_name."</td>";
						echo "<td>".$users_array[$i]->last_name."</td>";
						echo "<td>".$users_array[$i]->address."</td> ";
						echo "<td>".$users_array[$i]->creation_date."</td>";
						echo "<td>".$users_array[$i]->privileges."</td>";
						echo '<td><a class="btn btn-info btn-block" href="/table.php?edit='.$users_array[$i]->id.'">Muuda</a></td>';
						echo '<td><a class="btn btn-info btn-block" href="/table.php?delete='.$users_array[$i]->id.'">Kustuta</a></td></tr>';

					}
				}
				?>
			</table>
		</div>
		<div class="col-sm-2">
			<label class="text"> Otsi kasutajat </label>
				<form action="/table.php" method="get">
				<input class="form-control" name="keyword" type="search" value="<?=$keyword?>" ><br>
				<input type="submit" value="otsi" class="btn btn-info btn-block">
			</form>
		</div>
	</div>
</div>
	</html>
