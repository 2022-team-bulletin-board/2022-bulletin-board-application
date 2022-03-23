<?php
  require_once dirname(__FILE__) . '/../db/question.php';
  require_once dirname(__FILE__) . '/UsersFunc.php';

  // セッションの開始
  session_start();

  if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] !== "" &&
      isset($_GET["question_id"])
    ) {

    // セッションからユーザーidの取り出し
    $userId = $_SESSION["user_id"];

    // getからidの取り出し
    $questionId = $_GET["question_id"];
    // question.phpのtitleUpdateを呼び出し、結果を取得
    $results = deleteQuestion($userId, $questionId);

    var_dump($results);

    if (!isset($results)) {
      header("Location:./../home.php");
      exit();
    } else {
      $_SESSION["update_result"] = $results;

      header("Location:./../DetailQuestion.php?question_id=". $questionId);
      exit();
    }

  } else {
    header("Location:./../index.php");
    exit();
  }
?>
