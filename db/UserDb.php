<?php
  // このファイルではユーザーに関するdb処理を記述してほしいです

  // 現在の関数
  // ・登録処理: insertUserSql
  // ・ログイン処理: selectUserSalt, selectUser
  // ・ユーザー情報変更処理:updateName
  
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

  // ログイン機能(mailをチェックして、あればソルトを返す)
  function selectUserSalt($mail) {
    // ユーザー用のコネクションの挿入
    include dirname(__FILE__).'/userConnetcion.php';
    try {
      $sql = 'SELECT student_salt FROM users WHERE student_mail = :mail AND delete_flag = 0';
      // pdoのインスタンス化
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
      // 実行
      $res = $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if($result != null){
        return $result;
      } else {
        return "mailfail";
      }
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
    }
  }

  // ログイン機能(mailとハッシュ化したパスワードをチェックして、合致すればユーザーidと管理者フラグの値を返す)
  function selectUser($mail,$hashPassword) {
    // ユーザー用のコネクションの挿入
    include dirname(__FILE__).'/userConnetcion.php';
    try {
      $sql = 'SELECT user_id,admin_flag FROM users WHERE student_mail = :mail AND student_pass = :pass';
      // pdoのインスタンス化
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
      $stmt->bindValue(':pass', $hashPassword, PDO::PARAM_STR);
      // 実行
      $res = $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if($result != ""){
        return $result;
      } else {
        return "passwordfail";
      }
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
    }
  }

  // ユーザー情報の名前を変更するsql
  function updateName($changedName, $userId) {
    // ユーザー用のコネクションの挿入
    include dirname(__FILE__).'/userConnetcion.php';
    try {
      $sql = 'UPDATE users SET student_name=:changedName WHERE user_id=:userId;';
      // pdoのインスタンス化
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':changedName', $changedName, PDO::PARAM_STR);
      $stmt->bindValue(':userId', $userId, PDO::PARAM_STR);
      // 実行
      $res = $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if(!$result){
        return true;
      } else {
        return false;
      }
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
    }
  }
  
