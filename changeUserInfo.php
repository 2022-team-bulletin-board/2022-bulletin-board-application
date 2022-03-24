<?php
    session_start();

    require_once dirname(__FILE__).'/db/UserDb.php';
    require_once dirname(__FILE__).'/header.php';

    try{
        if(isset($_SESSION["user_id"])){
            if(isset($_SESSION["changePwResult"])){
                if($_SESSION["changePwResult"]){
                    $result = '<p class="result">パスワードの変更に成功しました。</p>';
                } else {
                    $result ='<p class="result">パスワードの変更に失敗しました。<br>もう一度お願いします。</p>';
                }
            }

            if(isset($_POST["changedName"])){
                $change_name_result = updateName($_POST["changedName"], $_SESSION["user_id"]);
                if($change_name_result){
                    $result = '<p class="result">名前の変更に成功しました。</p>';
                } else {
                    $result = '<p class="result">名前の変更に失敗しました。<br>もう一度お願いいたします。</p>';
                }
            }
        } else {
            header('Location: index.php');
            exit();
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
    <main>
        <?php echo $result!==""? $result:"" ?>
        <div class="center">
            <h1 class="question-text">どちらの情報を変更しますか？</h1>
            <div class="button-wrapper">
                <button type="submit" id="name" class="submit btn">名前</button>
                <button type="submit" id="password" class="submit btn">パスワード</button>
            </div>
        </div>

        <div id="nameContainer" class="overlay">
            <div id="namePopup" class="popup">
            <button type="button" id="clearNameBtn" class="clearBtn">X</button>
                <form action="changeUserInfo.php" method="POST" id="changeNameForm" class="changeForm">
                    <div>
                        <div class="form-item">
                            <label for="changedName">変更後の名前</label>
                            <p id="nameValueError" class="valueError">入力してください。</p>
                            <input type="text" id="changedName" name="changedName" placeholder="例）盛岡ジョビ男">
                        </div>
                        <input type="button" id="changeNameBtn" value="名前を変更" class="change-btn">
                    </div>
                </form>
            </div>
        </div>

        <div id="pwContainer" class="overlay">
            <div id="pwPopup" class="popup">
            <button type="button" id="clearPwBtn" class="clearBtn">X</button>
                <form action="./func/editPass.php" method="POST" id="changePwForm" class="changeForm">
                    <div>
                        <p id="pwValueError" class="valueError">パスワードが一致していません。</p>
                        <div class="form-item">
                            <label for="changedPwFirst">新規パスワード</label>
                            <input type="password" id="changedPwFirst" name="pw">
                        </div>
                        <div class="form-item">
                            <label for="changedPwSecond">確認用パスワード</label>
                            <input type="password" id="changedPwSecond" name="rePw">
                        </div>
                        <input type="button" id="changePwBtn" value="パスワードを変更" class="change-btn">
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
