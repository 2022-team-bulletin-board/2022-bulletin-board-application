<?php

  // セッションの開始
  session_start();

  // ファイルの挿入
  require_once dirname(__FILE__).'/func/UsersFunc.php';
  require_once dirname(__FILE__).'/func/sendMail.php';
  require_once dirname(__FILE__).'/db/UserDb.php';

  // 変数の初期化
  $sql = "INSERT INTO users(user_id, student_mail, student_name, student_pass, student_salt, delete_flag, admin_flag) VALUES ";
  $mail = "";
  $userName = "";

  // TODO
    // 管理者じゃないと実行できないようにする
  if (!isset($_SESSION["admin_id"])) {
    header('Location: home.php');
    exit();
  }


  // リロードによるpostの再送信をできないようにする
  if (isset($_POST["hidden_str"]) && isset($_SESSION["rand_str"]) && $_POST["hidden_str"] == $_SESSION["rand_str"]) {
    $_SESSION["rand_str"] = "";

    // ファイルの存在をチェックする
    // is_uploaded_file ネットの使い方ではnullチェックはいらないと書いているが、エラーがでるのでnullチェックもしている
    if (isset($_FILES["upfile"]) != NULL && is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
      if (move_uploaded_file($_FILES["upfile"]["tmp_name"], "files/" . $_FILES["upfile"]["name"])) {
        chmod("files/" . $_FILES["upfile"]["name"], 0644);
        $fileName = $_FILES["upfile"]["name"];
        // ファイルが存在しているかチェックする
        if (($handle = fopen("files/" . $fileName, "r")) !== FALSE) {
          // 1行ずつfgetcsv()関数を使って読み込む
          while (($data = fgetcsv($handle))) {
            $cnt = 0;
            // sql分の構築の開始
            $sql = $sql . "(null, '";
            foreach ($data as $value) {
              $sql = $sql . $value . "','";
              if ($cnt++ ===  0) {
                $mail = $value;
              } else {
                $userName = $value;
              }
            }
            $sql = substr($sql, 0, -2);
            $pw = randomStr();
            $salt = randomStr();
            $hashPw = hash256($pw, $salt);
            // メールの送信処理
            // 今回は一回ずつ送信している
            initialMail($mail, $pw, $userName);
            $sql = $sql . ", '" . $hashPw . "', '" . $salt . "', false, false), ";
          }
          fclose($handle);
          $sql = substr($sql, 0, -2);
          // sql分の構築の終わり

          // insert処理の呼び出し
          insertUserSql($sql);
        }
      } else {
        echo "ファイルをアップロードできません。";
      }
    } else {
      echo "ファイルが選択されていません。";
    }
  }

  // セッションにランダムな文字列を格納
  $_SESSION["rand_str"] = randomStr();

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
  <form action="CreateUser.php" method="post" enctype="multipart/form-data">
    <input type="file" name="upfile" id="">
    <input type="hidden" name="hidden_str" value=<?php echo $_SESSION["rand_str"]; ?>>
    <input type="submit" value="送信">
  </form>
</body>
</html>
