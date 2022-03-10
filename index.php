<?php
    include 'header.php';
    
    if(isset($_POST["id"]) && isset($_POST["password"])) {
        if($_POST["id"] == true && $_POST["password"] == true){
            echo "空じゃないよ";
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
                    ユーザID
                </th>
                <td>
                    <input type="text" name="id" value="">
                </td>
            </tr>
            <tr>
                <th>
                    パスワード
                </th>
                <td>
                    <input type="password" name="password" value="">
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
