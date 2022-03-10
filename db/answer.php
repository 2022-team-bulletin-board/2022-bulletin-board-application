<?php
  // 回答に関連する関数を管理するファイル

  session_start();

  // 現在の関数
  // ・回答登録 insertAnswer

    // 詳細ページの閲覧数の追加
    function insertAnswer($question_id, $answer_detail) {
      if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] !== "" && isset($_POST["answer_detail"]) && $_POST["answer_detail"] !== "") {
        include dirname(__FILE__).'/userConnetcion.php';
        try {
          // sql分の構築
          $sql = "insert into answer(question_id, user_id, answer_detail) values(:question_id, :user_id, :answer_detail)";
        
          // pdoのインスタンス化
          $stmt = $pdo->prepare($sql);
          $stmt->bindValue(':question_id', $question_id, PDO::PARAM_INT);
          $stmt->bindValue(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);
          $stmt->bindValue(':answer_detail', $_SESSION["user_id"], PDO::PARAM_STR);
          // 実行
          $res = $stmt->execute();
        } catch (PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
          echo "dbの実行に失敗しました。管理者への連絡をお願いします。";
        }
      }
    }
