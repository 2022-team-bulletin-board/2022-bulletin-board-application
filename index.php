<?php
    session_start();

    include 'header.php';
    require_once dirname(__FILE__).'/db/UserDb.php';
    require_once dirname(__FILE__).'/func/UsersFunc.php';

    session_start();

    class NotFoundValue extends Exception {
        public function __construct(){
            $this->message = '<p class="error-text">ログインに失敗しました。<br>メールアドレスかパスワードが間違っています。</p>';
          }
    }

    class EmptyValue extends Exception {
        public function __construct(){
            $this->message = '<p class="error-text">値が見つかりませんでした。<br>もう一度入力をお願いします。</p>';
          }
    }

    try {
        if(isset($_POST["mail"]) && isset($_POST["password"])) {
            if($_POST["mail"] && $_POST["password"]){
                $password = $_POST["password"];
                $mail = $_POST["mail"];
                
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
                        throw new NotFoundValue();
                    }
                } else {
                    throw new NotFoundValue();
                }
            } else {
                throw new EmptyValue();
            }
        } 
    } catch(NotFoundValue $v){
        echo $v->getMessage();
    } catch(EmptyValue $v){
        echo $v->getMessage();
    }
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
    <title>morijyobi</title>
</head>

<body>
<form class="login" action="index.php" method="post">
  <fieldset>
  	<legend class="legend">Login</legend>
    <div class="input">
    	<input type="email" id="mail" name="mail" placeholder="Email" tabindex="1" 
            value="<?php echo isset($_POST["mail"]) ? $_POST["mail"]: ""; ?>" required />
      <span><i class="fa fa-envelope"></i></span>
    </div>
    <div class="input">
    	<input type="password" id="password" name="password" placeholder="Password" tabindex="2" required />
      <span><i class="fa fa-lock"></i></span>
    </div>
    <button type="submit" id="login" class="submit" tabindex="3"><i class="fa fa-long-arrow-right"></i></button>
  </fieldset>
</form>
</body>
</html>
