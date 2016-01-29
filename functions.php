<?php
    require_once("../config.php");
    $database = "if15_richaas_1";
    // Sessioon, annab ligipääsu $_SESSION[]
    session_start();

    function getAllData($keyword=""){
      $search = '';
   		if($keyword == ""){
         // No search
         $search = "%%";
      }else{
         // Else search
         $search = "%".$keyword."%";
      }

      $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["username"], $GLOBALS["password"], $GLOBALS["database"]);

      $stmt = $mysqli->prepare("SELECT id, user_id, todo, date FROM todos WHERE deleted IS NULL AND todo LIKE ".$search);
      $stmt->bind_result($id_from_db, $user_id_from_db, $todo_from_db, $date_from_db);
      $stmt->execute();

      // massiiv kus hoiame todos
      $array = array();

      while($stmt->fetch()){
        // tühi objekt kus hoiame väärtusi
        $todo = new StdClass();

        $todo->id = $id_from_db;
        $todo->todo = $todo_from_db;
        $todo->user = $user_id_from_db;
        $todo->date = $date_from_db;

        //lisan objekti massiivi
        array_push($array, $todo);
      }

      //saadan tagasi
      return $array;

      $stmt->close();
      $mysqli->close();
    }

    function getTodoData($id){
      $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["username"], $GLOBALS["password"], $GLOBALS["database"]);

      $stmt = $mysqli->prepare("SELECT todo, date FROM todos WHERE id=? AND deleted IS NULL");
      $stmt->bind_param("i", $id);
      $stmt->bind_result($todo, $date);
      $stmt->execute();

      $todo = new StdClass();

      // kas sain rea andmeid
      if($stmt->fetch()){

        $todo->todo = $todo;
        $todo->date = $date;
             
      }else{
         // ei tulnud
         // kui id ei olnud (vale id)
         // või on kustutatud (deleted ei ole null)
         header("Location: table.php");
      }

         $stmt->close();
         $mysqli->close();

         return $todo;
    }

    function deleteTodoData($todo_id){

         $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["username"], $GLOBALS["password"], $GLOBALS["database"]);

         // uuendan välja deleted, lisan praeguse date'i
         $stmt = $mysqli->prepare("UPDATE todos SET deleted=NOW() WHERE id=?");
         $stmt->bind_param("i", $todo_id);
         $stmt->execute();

         // tühjendame aadressirea
         header("Location: table.php");

         $stmt->close();
         $mysqli->close();
    }

   	function updateTodoData($todo_id, $todo, $date){

         $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["username"], $GLOBALS["password"], $GLOBALS["database"]);

         $stmt = $mysqli->prepare("UPDATE todos SET todo=?, date=? WHERE id=?");
         $stmt->bind_param("ssi", $todo, $date, $todo_id);
         $stmt->execute();

         // tühjendame aadressirea
         header("Location: table.php");

         $stmt->close();
         $mysqli->close();

    }

    function logInUser($email, $hash){
      // Serveri ühendus, tegelikult tuleks GLOBALS meetodit vältida
      // praegusel juhul kui login.php's on kasutusel võtmesõna 'password'
      // asendub all serveri parool kasutaja logimise infoga.
      $mysqli = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);

      $stmt = $mysqli->prepare("SELECT id, email FROM user WHERE email=? AND password=?");

      // $hash asendab parooli välja
      // bind on turvalisuse jaoks
      $stmt->bind_param("ss", $email, $hash);
      $stmt->bind_result($id_from_db, $email_from_db);
      $stmt->execute();

      // Kui statement leiab vaste, vastasel juhul "Valed andmed!"
      if($stmt->fetch()){
          echo "Kasutaja logis sisse id=".$id_from_db;

          // sessioon, salvestatakse serveris
          $_SESSION['logged_in_user_id'] = $id_from_db;
          $_SESSION['logged_in_user_email'] = $email_from_db;

          //suuname kasutaja teisele lehel
          header("Location: data.php");

      }else{
          echo "Valed andmed!";
      }

      // Sulge query ja mysqli
      $stmt->close();
      $mysqli->close();

    }


    function createUser($create_email, $hash){
      require("../config.php");
      $database = "if15_richaas_1";

      // kasutada require funktsiooni sees pole ka kõige optimaalsem
      // parim lahendus oleks PDO kasutamine
      $mysqli = new mysqli($servername, $username, $password, $database);

      $stmt = $mysqli->prepare("INSERT INTO user (email, password) VALUES (?,?)");
      $stmt->bind_param("ss", $create_email, $hash);
      $stmt->execute();

      $stmt->close();
      $mysqli->close();

    }

 ?>
