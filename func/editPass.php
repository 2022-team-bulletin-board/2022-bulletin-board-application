<?php
  session_start();

  require_once dirname(__FILE__).'/../db/UserDb.php';
  require_once dirname(__FILE__).'/UsersFunc.php';

  // sessionに値がuser_idがいる
  // pwというpostデータがあり、pwとrePwは同じ値。
  // かつ、バリデーションチェックの実施をする。

  if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] !== ""){
    if(isset($_POST["pw"]) && $_POST["pw"] !== "" && pwVal($_POST["pw"])
      && isset($_POST["rePw"]) && $_POST["rePw"] !== "" && pwVal($_POST["rePw"])){
        $pw = $_POST["pw"];
        $userId = $_SESSION["user_id"];
    
        $result = updatePass($userId, $pw);

        if($result){
          $_SESSION["changePwResult"] = true;
          header("Location:../changeUserInfo.php");
          exit();
        } else {
          $_SESSION["changePwResult"] = false;
          header("Location:../changeUserInfo.php");
          exit();
        }
      } else {
        $_SESSION["changePwResult"] = false;
        header("Location:../changeUserInfo.php");
        exit();
      }
  } else {
    header("Location:../index.php");
    exit();
  }
?>
