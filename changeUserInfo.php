<?php
    session_start();

    if(isset($_SESSION["user_id"]) && $_SESSION["admin_id"] == true){

    } else {
        header('Location: index.php');
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
    <?php include 'header.php';?>

    <h1 class="center">どちらの情報を変更しますか？</h1>
    <button type="submit" id="name" class="submit">名前</button>
    <button type="submit" id="password" class="submit">パスワード</button>

    <div id="grey" class="grey">
        <div id="popup" class="popup">
        <button type="button" id="clearBtn" class="clearBtn">X</button>
            <form action="#" method="POST" class="changeNameForm">
                <div>
                    <label for="nameText">変更後の名前</label>
                    <input type="text" id="changedName" placeholder="盛岡ジョビ男">
                    <input type="submit" id="changeBtn" value="名前を変更" class="change-btn">
                </div>
            </form>
        </div>
    </div>
    

</body>
</html>
