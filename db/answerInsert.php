<?php
  // 回答を登録する処理

  session_start();
  

  // 送られてくるデータの存在チェック及び、空文字チェック(ログイン機能未実装のため一部固定値に変更)
  if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] !== "" &&
     isset($_POST["answer_detail"]) && $_POST["answer_detail"] !== "" && 
     isset($_POST["question_id"]) && $_POST["question_id"] !== "") {
    include dirname(__FILE__).'/executeUserconnection.php';
    try {
      // sql分の構築
      $sql = "call answer_insert_func(:question_id, :user_id, :answer_detail)";
    
      // pdoのインスタンス化
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':question_id', $_POST["question_id"], PDO::PARAM_INT);
      $stmt->bindValue(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);

      $stmt->bindValue(':answer_detail', $_POST["answer_detail"], PDO::PARAM_STR);
      // 実行
      $res = $stmt->execute();
      $result = $stmt->fetchall(PDO::FETCH_ASSOC);
      $_SESSION["ansInsResult"] = $result;
      header("Location:../DetailQuestion.php?question_id=" . $_POST["question_id"]);
      exit();
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
      echo "dbの実行に失敗しました。管理者への連絡をお願いします。";
    }
  } else {
    echo "おかしい";
  }
