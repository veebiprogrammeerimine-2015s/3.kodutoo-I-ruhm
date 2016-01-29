<?php
  require_once("functions.php");

  if(isset($_GET["update"])){
    updateTodoData($_GET["todo_id"], $_GET["todo"], $_GET["date"]);
  }

     //kas muutuja on aadressireal
     if(isset($_GET["edit_id"])){
         //trükin aadressirealt muutuja
         echo $_GET["edit_id"];

         //küsin andmed
         $todo = getTodoData($_GET["edit_id"]);
         var_dump($todo);

     }else{

         //kui muutujat ei ole,
         // ei ole mõtet siia lehele tulla
         // suunan tagasi table.php
         header("Location: table.php");

     }
?>
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get" >
     <input name="todo_id" type="hidden" value="<?=$_GET["edit_id"];?>">
     <input name="todo" type="text" value="<?=$todo->todo;?>" ><br>
     <input name="date" type="text" value="<?=$todo->date;?>"><br>
     <input name="update" type="submit" >
 </form>
