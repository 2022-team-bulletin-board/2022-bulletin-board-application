<?php
  session_start();
  require_once dirname(__FILE__).'/func/UsersFunc.php';
  require_once dirname(__FILE__).'/db/question.php';

  // ログイン済みかの確認
  if (isset($_SESSION["user_id"] && $_SESSION["user_id"] !== "") {

    // 質問投稿機能の実装
    // postにデータがあり、titleは100文字以内・詳細は空白ではなく、リロード対策用のhidden文字列がセッションの値と同じなら登録処理を実行する
    if (isset($_POST["title"]) && $_POST["title"] !== "" && mb_strlen($_POST["title"]) <= 100 && isset($_POST["detail"]) && $_POST["detail"] !== "" && isset($_SESSION["randomStr"]) && isset($_POST["hidden-filed"]) && $_SESSION["randomStr"] === $_POST["hidden-filed"]) {
      $_SESSION["randomStr"] = "";
      $title = $_POST["title"];
      $detail = $_POST["detail"];

      // 登録処理用テスト用変数
      $userId = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "1" ;
      insertQuestion($userId, $title, $detail);

      $questionId = latestUserQuestion($userId);

      // 遷移先の設定
      // 一旦は詳細ページ
      header("Location:DetailQuestion.php?question_id=".$questionId);
      exit();

    }

    // ランダムな文字列の生成
    $randomStr = randomStr();

    $_SESSION["randomStr"] = $randomStr;

  // ログインしていないならindexに遷移
  } else {
    header("Location:index.php");
    exit();
  }
?>
<!doctype html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <!--  css-link  -->
  <link rel="stylesheet" href="./css/framework/bulma/css/bulma.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">

  <link rel="stylesheet" href="./css/color.css">
  <link rel="stylesheet" href="./css/postQuestion.css">
  <!--  css-link-end  -->
  <title>質問投稿</title>
</head>

<body>
  <?php
    require_once dirname(__FILE__).'/header.php';
  ?>
  <section class="main section">
    <div class="is-8-widescreen is-10-tablet is-offset-2-widescreen is-offset-1-tablet is-centered column">
      <div class="field">
        <form action="postQuestion.php" method="post">
          <div class="control">
            <h2 class="subtitle has-text-left control is-size-4 mb-3">タイトル</h2>
          </div>
          <div class="control">
            <input type="text" class="input is-expanded" name="title">
          </div>
      </div>
      <div class="field">
        <div class="control">
          <h2 class="subtitle has-text-left control is-size-4 mb-3">本文</h2>
        </div>
        <div class="control content">
          <textarea id="simpleMDE" name="detail" cols="30" rows="10"></textarea>
        </div>
      </div>
      <input type="hidden" name="hidden-filed" value=<?php echo $randomStr; ?>>
      <div class="field has-text-right">
        <button id="postButton" class="button is-large">質問する</button>
      </div>
      </form>
      <!--        tag input area-->
      <!--        <div class="field">-->
      <!--            <div class="control">-->
      <!--                <h2 class="subtitle has-text-left control is-size-4 mb-3">タグ</h2>-->
      <!--            </div>-->
      <!--            <div class="control">-->
      <!--                <input-->
      <!--                        type="text"-->
      <!--                        class="input is-expanded"-->
      <!--                >-->
      <!--            </div>-->
      <!--        </div>-->
      <!--        end area-->
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
  <script>
    let simpleMDE = new SimpleMDE({
      element: document.getElementById('simpleMDE')
    });
  </script>
</body>

</html>
