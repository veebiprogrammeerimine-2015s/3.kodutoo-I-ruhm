<?php
require_once(__DIR__.'/functions.php');
require_once(__DIR__.'/user.class.php');

if(isset($_SESSION['logged_in_user_id'])){
  header("Location: /index.php");}

$userCreate = new userCreate($connection);
	$userLogin = new userLogin($connection);
$pw_error = "";
$username_error = "";
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
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if ($pw_error == "" and $username_error == ""){
			$response = $userCreate->createUser($username, $password);
		}
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset ($response->success->message)){
			$response = $userLogin->loginUser($username, $password);
		}
	}
  if(isset($response->success->user->id)){
	$_SESSION['logged_in_user_id'] = $response->success->user->id;
	$_SESSION['logged_in_user_username'] = $response->success->user->username;
}
	$page_title = "Register";
	$page_file_name = "create.php";

		exit();

	
  ?>
  <div class="text">Create User</div>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<?php if(isset($response->success)):	 ?>

  <p><?=$response->success->message;?></p>

  <?php	elseif(isset($response->error)): ?>

  <p><?=$response->error->message;?></p>

  <?php	endif; ?>

		<p>Email/Username</p>
		<input class="button" name="username" type="text" placeholder="example" value="<?php echo $username;?>" >* <?php echo $username_error;?>

		<p>Password</p>
		<input class="button" name="password" type="password" placeholder="Password" >* <?php echo $pw_error;?>
		<br><br>
		<input name="create" type="submit" value="Create User">
		<br><br>
	</form>
