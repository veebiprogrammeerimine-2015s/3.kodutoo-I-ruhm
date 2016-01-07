<?php
require_once(__DIR__.'/functions.php');
require_once(__DIR__.'/user.class.php');
if(isset($_SESSION['logged_in_user_id'])){
  	header("Location: /table.php");
    die();

}


$userLogin = new userLogin($connection);
$pw_error = $username_error = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["username"])) {
		$username_error = "Name is required";
		} else {
		$username = test_input($_POST["username"]);
		}
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["password"])) {
		$pw_error = "Password is required";
		} else {
		$password = test_input($_POST["password"]);
		$password = hash(sha512, $password);
		}

		if ($pw_error == "" and $username_error == ""){
			$response = $userLogin->loginUser($username, $password);

		}
	}

  $_SESSION['logged_in_user_username'] = $response->success->user->username;
	$_SESSION['logged_in_user_id'] = $response->success->user->id;
?>
<!DOCTYPE html>
<html lang="et">

<body>

  <a href="create.user.php">Create a User</a>


  <div id="login" class="container-fluid">
  	<div class="row">

  		<div class="col-sm-3">
  		<p style="font-size:30px";>Log In</p>
  			<form action="<?php echo $_SERVER["PHP_SELF"]?> " method="post">


  				<?php if(isset($response->success)):	 ?>

  				<p><?=$response->success->message;?></p>

  				<?php	elseif(isset($response->error)): ?>

  				<p><?=$response->error->message;?></p>

  				<?php	endif; ?>
  			<div class="form-group">
  				<p>Email/Username</p>
  				<input name="username" type="text" placeholder="example" value="<?php echo $username;?>" class="form-control"> <?php echo $username_error;?> <br>
  			</div>
  			<p>Password</p>
  			<div class="row">
  				<div class="col-lg-8">

  					<div class="form-group">
  						<input name="password" type="password" placeholder="Password" class="form-control"> <?php echo $pw_error;?>
  						<br><br>
  					</div>
  				</div>
  				<div class="col-lg-4">
  					<button type="submit" class="btn btn-info btn-block">Login</button>
  				</div>
  			</div>
  			</form>
  		</div>
  	</div>
  </div>
</body>
</html>
