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
                    } else {
                        $_SESSION["user_id"] = $judge["user_id"];
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
    <script type="text/javascript" src="js/login.js"></script>
    <title>morijyobi</title>
</head>

<body>
    <form action="index.php" method="post">
    <div align="center">
        <h1>ログイン</h1>
        <table border="0">
            <tr>
                <th>
                    mail address
                </th>
                <td>
                    <input type="text" id="mail" name="mail" value="sample@jp.com">
                </td>
            </tr>
            <tr>
                <th>
                    password
                </th>
                <td>
                    <input type="password" id="password" name="password" value="morijyobi2021">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" id="login" value="ログイン" disabled="true">
                </td>
            </tr>
        </table>
    </div>
</form>
</body>
</html>
