<?php
  // ユーザー名
  $user = "student";
  // パスワード
  $pass = "@Morijyobi2021";
  // データベース名
  $database = "bba";
  // サーバー
  $server = "localhost";

  // DSM文字列の生成
  $dsn = "mysql:host={$server};dbname={$database};charset=utf8";

  // mysqlへの接続
  try{
    // PDOのインスタンスを作成し、DBに接続する
    $pdo = new PDO($dsn, $user, $pass);
    // プリペアドステートメントのエミュレーションを無効か
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // 例外がスローされるように変更する
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "成功";
  }catch(Exception $e){
    echo "接続エラー:";
    echo $e -> getMessage();
    exit();
  }
