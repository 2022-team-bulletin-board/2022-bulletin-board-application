<?php
require_once dirname(__FILE__).'/../db/bestAnswer.php';

session_start();

//  question.question_bestanswer に選択した answer_id を入れる
if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] != "" && isset($_GET["question_id"]) && isset($_GET["answer_id"])) {
//  question.user_id, question_question_id, の一致、answer_id の存在確認
  $userId = $_SESSION["user_id"];

  $questionId = $_GET["question_id"];

  $answerId = $_GET["answer_id"];

  changeBestAnswer($userId, $questionId, $answerId);

  header("Location:../DetailQuestion.php?question_id=" . $questionId);
  exit();
} else {
  header("Location:../index.php");
  exit();
}
