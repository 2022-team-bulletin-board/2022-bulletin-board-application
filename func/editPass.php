<?php
  session_start();

  include dirname(__FILE__).'/../db/UserDb.php';
  include dirname(__FILE__).'/UsersFunc.php';

  // sessionに値がuser_idがいる
  // pwというpostデータがあり、pwとrePwは同じ値。
  // かつ、バリデーションチェックの実施をする。
  if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] !== "" &&
      isset($_POST["pw"]) && $_POST["pw"] !== "" && pwVal($_POST["pw"]) &&
      isset($_POST["rePw"]) && $_POST["rePw"] !== "" && pwVal($_POST["rePw"])
  ) {
    $pw = $_POST["pw"];
    $userId = $_SESSION["user_id"];

    updatePass($userId, $pw);
    // 遷移先は任意でお願いします。
    header("Location:../home.php");
    exit();
  } else {
    // 遷移先は任意でお願いします。
    header("Location:../index.php");
    exit();
  }
?>

<!-- デバック用コード -->
<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="editPass.php" method="post">
    <input type="text" name="pw" id="">
    <input type="text" name="rePw" id="">
    <input type="submit" value="送信">
  </form>
</body>
</html> -->
