<?php
require_once(__DIR__.'/functions.php');

class user_manage
{

    private $connection;

    function __construct($connection){
        $this->connection = $connection;
    }


    function loginUser($username_to_db, $password_to_db){

        $response = new StdClass();

        $stmt = $this->connection->prepare("SELECT id FROM userbase WHERE username=?");
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
        $stmt = $this->connection->prepare("SELECT id, username FROM userbase WHERE username = ? AND password = ? ");
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

    function createUser($username, $password){

        $response = new StdClass();

        $stmt = $this->connection->prepare("SELECT id FROM userbase WHERE username=?");
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
        $stmt = $this->connection->prepare("INSERT INTO userbase (username, password) VALUES (?,?)");
        $stmt->bind_param("ss", $username, $password);

        if($stmt->execute()){

            $success = new StdClass();
            $success->message = "Kasutaja edukalt loodud";

            $response->success = $success;
            header("Location: index.php");


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

    function getAllUsers(){

        
        $stmt = $this->connection->prepare("SELECT id, first_name, last_name, address FROM userbase WHERE deleted IS NULL");
        echo $this->connection->error;
        $stmt->bind_result($id_from_db, $first_name_from_db, $last_name_from_db, $address_from_db);
        $stmt->execute();
        $array = array();
        while($stmt->fetch()) {

            $users = new StdClass();
            $users->id = $id_from_db;
            $users->first_name = $first_name_from_db;
            $users->last_name = $last_name_from_db;
            $users->address = $address_from_db;

            array_push($array, $users);

        }

        if($keyword == ""){
            //ei otsi
            $search = "%%";
        }else{
            //otsime
            $search = "%".$keyword."%";
        }
        $stmt = $this->connection->prepare("SELECT id, first_name, last_name, address FROM userbase WHERE deleted IS NULL ");
        echo $this->connection->error;

        $stmt->bind_result($id_from_db, $first_name_from_db, $last_name_from_db, $address_from_db);
        $stmt->execute();
        $array = array();
        while($stmt->fetch()){

            $users = new StdClass();
            $users->id = $id_from_db;
            $users->first_name = $first_name_from_db;
            $users->last_name = $last_name_from_db;
            $users->address = $address_from_db;
            array_push($array, $users);

        }

        return $array;
    }


    function deleteUsers($user_id){

        $stmt = $this->connection->prepare("UPDATE userbase SET deleted=NOW() WHERE id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();



        $stmt->close();
    }


    function updateUsers($first_name, $last_name, $address,$id){

        $stmt = $this->connection->prepare("UPDATE userbase SET first_name=?, last_name=?, address=? WHERE id=?");
        echo $this->connection->error;
        $stmt->bind_param("ssss", $first_name, $last_name, $address,$id);
        $stmt->execute();

        // tühjendame aadressirea
        header("Location: table.php");

        $stmt->close();

    }
    function arduinput($temperatuur, $andur){
        $response = new stdClass();
        $stmt = $this->connection->prepare("INSERT INTO temperatuurid(temperatuur, andur) VALUES (?,?)");
        echo $this->connection->error;
        $stmt->bind_param("ds",$temperatuur, $andur);

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
    }

    function gettemp1(){
        $stmt = $this->connection->prepare("SELECT aeg, temperatuur FROM temperatuurid WHERE andur=1");
        echo $this->connection->error;
        $stmt->bind_result($time_fromdb,$temp_fromdb);
        $stmt->execute();
        $array = array();
        while($stmt->fetch()) {

            $temp = new StdClass();
            $temp->time = $time_fromdb;
            $temp->temp = $temp_fromdb;
            array_push($array, $temp);

        }
        return $array;
    }
	function editUser($userfirstname, $userlastname, $useraddress){
		$response = new StdClass();
		$stmt = $this->connection->prepare("INSERT INTO userbase(first_name, last_name, address) VALUES(?,?,?)");
		$stmt->bind_param("sss", $userfirstname, $userlastname, $useraddress);
		if($stmt->execute()){

            $success = new StdClass();
            $success->message = "andmed lisatud";

            $response->success = $success;
            header("Location: table.php");


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


?>