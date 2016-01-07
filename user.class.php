<?php
require_once(__DIR__.'/functions.php');

class userCreate {
    private $connection;

	function __construct($connection){
        $this->connection = $connection;
		}

	function createUser($username, $password){

		$response = new StdClass();

        $stmt = $this->connection->prepare("SELECT id FROM users WHERE username=?");
		#echo($this->connection->error);
		$stmt->bind_param("s", $username);
		$stmt->bind_result($id);
		$stmt->execute();
		if($stmt->fetch()){

			$error = new StdClass();
			$error->id = 0;
			$error->message = "Kasutajanimi on juba kasutusel";
			$response->error = $error;

			return $response;

		}
		$stmt->close();
        $stmt = $this->connection->prepare("INSERT INTO users (username, password, creation_date) VALUES (?,?,NOW())");
        $stmt->bind_param("ss", $username, $password);

        if($stmt->execute()){

			$success = new StdClass();
			$success->message = "Kasutaja edukalt loodud";

			$response->success = $success;


		} else {
			#echo($stmt->error);
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Hiireke läks katki";
			$response->error = $error;

		}
        $stmt->close();

        return $response;
    }

}
class userLogin {
    private $connection;

	function __construct($connection){
        $this->connection = $connection;
		}

	function loginUser($username_to_db, $password_to_db){

		$response = new StdClass();

        $stmt = $this->connection->prepare("SELECT id FROM users WHERE username=?");
		echo($this->connection->error);
		$stmt->bind_param("s", $username_to_db);
		$stmt->execute();
		if(!$stmt->fetch()){

			$error = new StdClass();
			$error->id = 0;
			$error->message = "Tundmatu kasutaja!";
			$response->error = $error;

			return $response;

		}
		$stmt->close();
        $stmt = $this->connection->prepare("SELECT id, username FROM users WHERE username = ? AND password = ? ");
		echo($this->connection->error);
        $stmt->bind_param("ss", $username_to_db, $password_to_db);
		$stmt->bind_result($id_from_db, $username_from_db);
		$stmt->execute();
		if($stmt->fetch()){

			$success = new StdClass();
			$success->message = "Edukalt sisse logitud!!!";

			$user = new StdClass();
			$user->id = $id_from_db;
			$user->username = $username_from_db;


			$success->user = $user;

			$response->success = $success;


		} else {
			echo($stmt->error);
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Meie hampstritel jooksev server on ülekoormatud palun oodake.";
			$response->error = $error;

		}
        $stmt->close();
        return $response;
    }

}
class userEdit {
	private $connection;

	function __construct($connection){
        $this->connection = $connection;
		}

	function editUser($userfirstname, $userlastname, $useraddress){

		$response = new StdClass();

		$stmt = $this->connection->prepare("UPDATE users SET first_name=?, last_name=?, address=? WHERE id=?" );
		#echo($this->connection->error);
		$stmt->bind_param("sssi", $userfirstname, $userlastname, $useraddress, $_SESSION['logged_in_user_id']);
		//$stmt->execute();
		//echo($this->connection->error);
		if($stmt->execute()){

			$success = new StdClass();
			$success->message = "Andmed uuendatud";

			$response->success = $success;


		} else {
			#echo($stmt->error);
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Hiireke läks katki";
			$response->error = $error;

		}
        $stmt->close();

        return $response;
    }

}
class getAllUsers{
	private $connection;

	function __construct($connection){
        $this->connection = $connection;
	}
	function getAllUsers($keyword=""){

		if($keyword == ""){
			//ei otsi
			$search = "%%";
		}else{
			//otsime
			$search = "%".$keyword."%";
		}
		$stmt = $this->connection->prepare("SELECT id, first_name, last_name, address, username, creation_date, privileges from users WHERE deleted IS NULL AND (username LIKE ?)");
		$stmt->bind_param("s", $search);
		$stmt->bind_result($id_from_db, $first_name_from_db, $last_name_from_db, $address_from_db, $username_from_db, $creation_date_from_db, $privileges_from_db);
		$stmt->execute();
		$array = array();
		while($stmt->fetch()){

			$users = new StdClass();
			$users->id = $id_from_db;
			$users->address = $address_from_db;
			$users->first_name = $first_name_from_db;
			$users->username = $username_from_db;
			$users->creation_date = $creation_date_from_db;
			$users->last_name = $last_name_from_db;
			$users->privileges = $privileges_from_db;
			array_push($array, $users);

			}

		return $array;
	}
}
class deleteUsers{
	private $connection;

	function __construct($connection){
        $this->connection = $connection;
		}
	function deleteUsers($user_id){

		$stmt = $this->connection->prepare("UPDATE users SET deleted=NOW() WHERE ID=?");
		$stmt->bind_param("i", $user_id);
		$stmt->execute();



		$stmt->close();
	}
}
class updateUsers{
	private $connection;

	function __construct($connection){
        $this->connection = $connection;
		}
	function updateUsers($first_name_to_db, $last_name_to_db, $address_to_db, $creation_date_to_db, $privileges_to_db, $id_to_db){

		$stmt = $this->connection->prepare("UPDATE users SET first_name=?, last_name=?, address=?, creation_date=?, privileges=? WHERE id=?");
		$stmt->bind_param("sssssi",$first_name_to_db, $last_name_to_db, $address_to_db, $creation_date_to_db, $privileges_to_db, $id_to_db);
		$stmt->execute();

		// tühjendame aadressirea
    header("Location: /table.php");

		$stmt->close();

	}
}
?>
