<?php
    require_once("../config.php");
    $database = "if15_richaas_1";
    // Sessioon, annab ligipääsu $_SESSION[]
    session_start();

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
