<?php
    session_start();

    require_once dirname(__FILE__).'/db/UserDb.php';
    include 'header.php';

    try{
        if(isset($_SESSION["user_id"]) && $_SESSION["admin_id"] == true){
            if(isset($_POST["changedName"])){
                $change_name_result = updateName($_POST["changedName"], $_SESSION["user_id"]);
                if($change_name_result){
                    echo "名前の変更に成功しました";
                } else {
                    echo "名前の変更に失敗しました。<br>もう一度お願いいたします。";
                }
            }
        } else {
            header('Location: index.php');
        }
    } catch(Exception $e){
        echo $e;
    }
    
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/changeUserInfo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="text/javascript" src="js/changeUserInfo.js"></script>
    <title>ユーザー情報変更画面</title>
</head>
<body>

    <h1 class="center">どちらの情報を変更しますか？</h1>
    <button type="submit" id="name" class="submit">名前</button>
    <button type="submit" id="password" class="submit">パスワード</button>

    <div id="nameContainer" class="nameContainer">
        <div id="namePopup" class="namePopup">
        <button type="button" id="clearNameBtn" class="clearNameBtn">X</button>
            <form action="changeUserInfo.php" method="POST" id="changeNameForm" class="changeNameForm">
                <div>
                    <label for="changedName">変更後の名前</label>
                    <input type="text" id="changedName" name="changedName" placeholder="盛岡ジョビ男">
                    <input type="button" id="changeNameBtn" value="名前を変更" class="change-name-btn">
                </div>
            </form>
        </div>
    </div>

    <div id="pwContainer" class="pwContainer">
        <div id="pwPopup" class="pwPopup">
        <button type="button" id="clearPwBtn" class="clearPwBtn">X</button>
            <form action="./func/editPass.php" method="POST" id="changePwForm" class="changePwForm">
                <div>
                    <label for="changedPwFirst">変更後のパスワード:一回目</label>
                    <input type="text" id="changedPwFirst" name="pw">
                    <label for="changedPwSecond">変更後のパスワード:二回目</label>
                    <input type="text" id="changedPwSecond" name="rePw">
                    <input type="submit" id="changePwBtn" value="パスワードを変更" class="change-pw-btn">
                </div>
            </form>
        </div>
    </div>

</body>
</html>
