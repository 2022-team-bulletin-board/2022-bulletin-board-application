<?php

  function changeBestAnswer($userId, $questionId, $answerId) {
    include dirname(__FILE__).'/userConnetcion.php';
    var_dump($userId);
    var_dump($questionId);
    var_dump($answerId);
    try {
      $sql = "update question set question_bestanswer = (select answer_id from answer where answer.answer_id = :answerId and answer.question_id = :questionId) where question.user_id = :userId and question.question_id = :questionId2";

      $stm = $pdo->prepare($sql);

      $stm->bindValue(':answerId', $answerId, PDO::PARAM_INT);
      $stm->bindValue(':questionId', $questionId, PDO::PARAM_INT);
      $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
      $stm->bindValue(':questionId2', $questionId, PDO::PARAM_INT);

      $res = $stm->execute();
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
      echo "dbの実行に失敗しました。管理者への連絡をお願いします。";
    }
  }