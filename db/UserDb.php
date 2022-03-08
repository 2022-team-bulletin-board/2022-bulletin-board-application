<?php
  // このファイルではユーザーに関するdb処理を記述してほしいです

  // 現在の関数
  // ・登録処理
  
  // 新規ユーザー作成関数
  function insertUserSql($sql) {
    // 管理者用のコネクションの挿入
    include dirname(__FILE__).'/adminConnection.php';
    try {
      // pdoのインスタンス化
      $stmt = $pdo->prepare($sql);
      // 実行
      $res = $stmt->execute();
      echo "アカウントの作成に成功しました。";
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
      echo "<br>アカウントの作成に失敗しました。csvファイルの確認をお願いします";
    }
  }
  
