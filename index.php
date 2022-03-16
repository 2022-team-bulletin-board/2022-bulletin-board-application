<?php
    include 'header.php';
    require_once dirname(__FILE__).'/db/UserDb.php';
    require_once dirname(__FILE__).'/func/UsersFunc.php';

    if(isset($_POST["mail"]) && isset($_POST["password"])) {
        if($_POST["mail"] == true && $_POST["password"] == true){
            $mail = $_POST["mail"];
            $password = $_POST["password"];

            $salt = selectUserSalt($mail);
            if($salt != "mailfail"){
                $hashPw = hash256($password, $salt["student_salt"]);

                $judge = selectUser($mail, $hashPw);
            
                if($judge != "passwordfail"){
                    if($judge["admin_flag"] == 1){
                        $_SESSION["user_id"] = $judge["user_id"];
                        $_SESSION["admin_id"] = true;
                        header('Location: home.php');
                    } else {
                        $_SESSION["user_id"] = $judge["user_id"];
                        header('Location: home.php');
                    }
                } else {
                    echo '<p class="error-text">ログインに失敗しました。<br>パスワードが間違っています。</p>';
                }
            } else {
                echo '<p class="error-text">ログインに失敗しました。<br>メールアドレスが間違っています。';
            }
        };
    };
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="text/javascript" src="js/login.js"></script>
    <title>morijyobi</title>
</head>

<body>
<form class="login" action="index.php" method="post">
  <fieldset>
  	<legend class="legend">Login</legend>
    <div class="input">
    	<input type="email" id="mail" name="mail" placeholder="Email" required />
      <span><i class="fa fa-envelope"></i></span>
    </div>
    <div class="input">
    	<input type="password" id="password" name="password" placeholder="Password" required />
      <span><i class="fa fa-lock"></i></span>
    </div>
    <button type="submit" id="login" class="submit" disabled="true"><i class="fa fa-long-arrow-right"></i></button>
  </fieldset>
</form>
</body>
</html>
