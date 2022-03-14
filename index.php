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
                    echo "test ${judge["user_id"]} {$judge["admin_flag"]}";
                } else {
                    echo "ログインに失敗しました。<br>パスワードが間違っています。";
                }
            } else {
                echo "ログインに失敗しました。<br>メールアドレスが間違っています。";
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
    <title>morijyobi</title>
</head>

<body>
    <form action="index.php" method="post">
    <h1>ログイン</h1>
    <div align="center">
        <table border="0">
            <tr>
                <th>
                    mail address
                </th>
                <td>
                    <input type="text" name="mail" value="aiueo">
                </td>
            </tr>
            <tr>
                <th>
                    password
                </th>
                <td>
                    <input type="password" name="password" value="4kcbiso17bi8gg4osogs">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="ログイン">
                </td>
            </tr>
        </table>
    </div>
</form>
</body>
</html>
