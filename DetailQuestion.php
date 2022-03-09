<?php
    require_once dirname(__FILE__).'/db/question.php';

    // セッションの開始
    session_start();

    // if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] !== "" &&
    //     isset($_GET["question_id"]) && $_GET["question_id"] !== "" 
    //   ) {
      // $user_id = $_SESSION["user_id"];
      $question_id = $_GET["question_id"];
      $result = detailQuestion($question_id);
      if(count($result) === 0){
        header("Location:notFoundError.php");
      }
    // } else {
    //   header("Location:index.php");
    //   exit();
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <?php
    var_dump($result);
  ?>
</body>
</html>
