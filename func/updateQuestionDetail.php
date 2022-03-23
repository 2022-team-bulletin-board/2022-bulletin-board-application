<?php
  require_once dirname(__FILE__) . '/../db/question.php';
  require_once dirname(__FILE__) . '/UsersFunc.php';

  // セッションの開始
  session_start();

  if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] !== "" &&
      isset($_POST["detail"]) && $_POST["detail"] !== "" &&
      isset($_POST["question_id"])
    ) {

  // セッションからユーザーidの取り出し
  $userId = $_SESSION["user_id"];

  // postからdetail, idの取り出し
  $detail = $_POST["detail"];
  $questionId = $_POST["question_id"];
  // question.phpのtitleUpdateを呼び出し、結果を取得
  $results = detailUpdate($userId, $questionId, $detail);

  $_SESSION["update_result"] = $results;

  header("Location:./../DetailQuestion.php?question_id=". $questionId);
  exit();

  } else {
    header("Location:./../index.php");
    exit();
  }
?>
