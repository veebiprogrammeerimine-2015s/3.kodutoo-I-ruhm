<?php
/**
 * Created by PhpStorm.
 * User: JaanMartin
 * Date: 12.01.2016
 * Time: 10:11
 */
require_once(__DIR__.'/functions.php');
require_once(__DIR__.'/user_manage_class.php');

$user_manage = new user_manage($connection);
$username_error = $pw_error = $usernamecreate_error = $passwordcreate_error ="";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty($_POST["loginusername"])){
        $username_error = "Username is required";
    }else{
        //echo "kasutajanimi db";
        $username_to_db = clean_input($_POST["loginusername"]);
    }
    if(empty($_POST["loginpassword"])){

        $pw_error = "Password is required";
    }else{
        //echo "pass db";
        $loginpassword = clean_input($_POST['loginpassword']);
        $password_to_db = hash(sha512, $loginpassword);
    }
    if(empty($_POST["createusername"])){
        $usernamecreate_error = "Username is required";
    }else{
        $createusername = clean_input($_POST["createusername"]);
      //  echo"create kasutajanimi korras";
    }
    if(empty($_POST["createpassword"])){
        $passwordcreate_error = "Password is required";
    }else{
        $createpassword = clean_input($_POST['createpassword']);
        $createpassword=hash(sha512, $createpassword);
       // echo"create password korras";
    }
    if($username_error== "" and $pw_error ==""){
        //echo"läheme db";
        $response = $user_manage->loginUser($username_to_db, $password_to_db);
    }
    if($passwordcreate_error == "" and $usernamecreate_error ==""){
        $response = $user_manage->createUser($createusername, $createpassword);
       // echo"create läheb baasi";
    }
}



$_SESSION['logged_in_uid'] = $response->success->user->id;
$_SESSION['logged_in_username'] = $response->success->user->username;
if(isset($_SESSION['logged_in_uid'])){
    header("Location: table.php");
}
?>
<!DOCTYPE html>
<html lang="et"">
<head>

    <meta charset="utf-8">
    <title>Smth Smth</title>
    <link rel="stylesheet" type="text/css" href="page.css" />
</head>
<body>



    <div class="main">
        <div class="block"">
            <form action="<?php echo $_SERVER["PHP_SELF"]?> " method="post">

            <h1>Login</h1>
                <p>
                <label for="loginusername">Username</label>
                <input name="loginusername" type="text" placeholder="Username"><?php echo"$username_error";?>
                </p>
                <p>

                <label for="loginpassword">Password</label>
                <input name="loginpassword" type="text" placeholder="Password"><?php echo"$pw_error";?>
                </p>
                <p>
            <button name="login"type="submit">Login</button>
                </p>
            </form>
        </div>

        <div class="block"">

            <form action="<?php echo $_SERVER["PHP_SELF"]?> " method="post">
            <h1>Create User</h1>
             <h2>
                <?php if(isset($response->success)):	 ?>

                    <p><?=$response->success->message;?></p>

                <?php	elseif(isset($response->error)): ?>

                    <p><?=$response->error->message;?></p>

                <?php	endif; ?>
             </h2>
            <p>
                <label for="createusername">Username</label>
            <input name="createusername" type="text" placeholder="Username">
            </p>
            <p>
                <label for="createpassword">Password</label>
            <input name="createpassword" type="text" placeholder="Password">
            </p>
                <p>
            <button name="create" type="submit">Create User</button>
                </p>
            </form>
        </div>
    </div>
</body>
</html>