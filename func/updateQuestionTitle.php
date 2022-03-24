<?php
  require_once dirname(__FILE__) . '/../db/question.php';
  require_once dirname(__FILE__) . '/UsersFunc.php';

  // セッションの開始
  session_start();

  if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] !== "" &&
      isset($_POST["title"]) && $_POST["title"] !== "" && mb_strlen($_POST["title"]) <= 100 &&
      isset($_POST["question_id"])
    ) {

  // セッションからユーザーidの取り出し
  $userId = $_SESSION["user_id"];

  // postからtitle, idの取り出し
  $title = $_POST["title"];
  $questionId = $_POST["question_id"];
  // question.phpのtitleUpdateを呼び出し、結果を取得
  $results = titleUpdate($userId, $questionId, $title);

  $_SESSION["update_result"] = $results;

  header("Location:./../DetailQuestion.php?question_id=". $questionId);
  exit();

  } else {
    header("Location:./../index.php");
    exit();
  }
?>
