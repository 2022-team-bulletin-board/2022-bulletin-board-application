<?php
    require_once dirname(__FILE__).'/db/question.php';

    // セッションの開始
    session_start();

    // if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] !== "" &&
    //     isset($_GET["question_id"]) && $_GET["question_id"] !== "" 
    //   ) {

      // セッションからユーザーidの取り出し
      // $user_id = $_SESSION["user_id"];

      // getからquestion_idの取り出し
      $question_id = $_GET["question_id"];
      // question.phpのdetailQuestionを呼び出し、結果を取得
      $results = detailQuestion($question_id);
      // resultに値がない場合は、存在しないページへのアクセスになるのでエラーページに遷移させる
      if(count($results) === 0){
        header("Location:notFoundError.php");
      }

      // question_idの存在が確認できたので閲覧数の追加
      questionViewAdd($question_id);


    // } else {
    //   header("Location:index.php");
    //   exit();
    // }
?>
<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=chrome">
  <link rel="stylesheet" href="./css/bulma/css/bulma.min.css">
  <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
  <link rel="stylesheet" href="./css/detailQuestion.css">

  <title>質問詳細</title>
</head>
<body>
<section class="main section">
  <div class="column is-centered is-8-widescreen is-10-tablet is-offset-2-widescreen is-offset-1-tablet is-offset-1">
  <?php
  $updateDate = isset($results[0]["question_update"]) ? $results[0]["question_update"] : "更新ナシ";
  echo <<< "EOS"
    <h1 class="title is-medium has-text-left">
      {$results[0]["question_title"]}
    </h1>
    <!--    ユーザー情報の表示部分   -->
    <div class="content columns is-mobile is-multiline mt-4 userInfo">
      <figure class="image is-64x64 is-vcentered">
        <img src="https://placehold.jp/24/1fc7bb/ffffff/150x150.png?text=user%20image" alt="ダミー画像" class="is-rounded">
      </figure>
      <div class="column pb-0 userInfoDiv">
        <p class="is-size-6-widescreen is-size-7-mobile mb-0">
          {$results[0]["qu_name"]}
        </p>
        <div class="columns questionDateWrapper is-mobile">
          <p class="column is-3 is-offset-7-widescreen is-offset-6
           pb-0 mb-1 has-text-right">
            質問日時
          </p>
          <p class="column is-3 has-text-right
            pb-0 mb-0">
            {$results[0]["question_created"]}
          </p>
        </div>
      </div>
      <div class="column is-12 is-mobile mb-2 mr-2">
        <div class="columns is-mobile">
          <p class="has-text-right column mb-0 py-0 is-2 is-offset-8-widescreen is-offset-8">閲覧数</p>
          <p class="has-text-centered mb-0 pt-0 column is-2">
            <span>{$results[0]["question_view"]}</span>回
          </p>
        </div>
      </div>
    </div>

    <div class="content question">
      <div id="questionTextArea" class="p-4">
        {$results[0]["question_detail"]}
      </div>
      <div id="questionTagArea" class="px-4 tags mt-3">
<!--        <span class="tag is-link is-light">タグの</span>-->
<!--        <span class="tag is-link is-light">はみ出るまで伸ばすと</span>-->
<!--        <span class="tag is-link is-light">自動で改行されて</span>-->
<!--        <span class="tag is-link is-light">表示される</span>-->
      </div>
      <div class="columns is-mobile is-vcentered">
        <div class="column">
          <button class="button is-small is-link is-inverted">編集</button>
        </div>
        <div class="columns questionDateWrapper is-mobile">
          <p class="has-text-left column is-4 is-offset-5 has-text-right" style="margin-bottom: 0;">最終編集日時</p>
          <p class="has-text-left column is-3 has-text-right">
            {$updateDate}
            <!--            日付の表示を、桁が変わったタイミングで更新する   -->
            <!--            バックエンドかフロントで処理する    -->
          </p>
        </div>
      </div>
    </div>

EOS ;
    $answerCount = count($results);
    echo `<h2 class="subtitle mt-6">{$answerCount}件の回答</h2>`;
    foreach ($results as $result) {
      $ansUpdate = isset($result["answer_update"]) ? $result["answer_update"] : "更新ナシ";
      $ansUser = isset($result["qa_name"]) ? $result["qa_name"] : "削除済みユーザー";
      $best = $results[0]["question_bestanswer"] === $result["answer_id"] ? true : false;
      if ($best) {
        echo <<<"EOS"
<div>
<h3>回答者: {$ansUser}  {$best}</h3>
<p>回答日時: {$result["answer_date"]}</p>
<p>回答更新日: {$ansUpdate}</p>
<p>回答: {$result["answer_detail"]}</p>
</div>
    <div class="content bestAnswer">
      <div class="content columns is-mobile mt-4 userInfo">
        <figure class="image is-64x64 is-vcentered">
          <img src="https://placehold.jp/24/1fc7bb/ffffff/150x150.png?text=user%20image" alt="ダミー画像" class="is-rounded">
        </figure>
        <div class="column">
          <p class="is-size-6-widescreen is-size-7-mobile mb-0">
            {$ansUser}
          </p>
          <div class="columns questionDateWrapper is-mobile">
            <div id="bestAnswer" class="column p-0 has-text-right is-offset-3 is-offset-4-widescreen">
              <!--              後でベストアンサーのアイコンを入れます。-->
            </div>
            <p class="has-text-left column is-3 has-text-right">質問日時</p>
            <p class="has-text-left column is-3 has-text-right">
              {$result["answer_date"]}
            </p>
          </div>
        </div>
      </div>
      <div class="py-4 px-6 answerTextArea">
        {$result["answer_detail"]}
      </div>
      <div class="columns answerDateWrapper mb-5 is-mobile">
        <p class="has-text-left column is-4 is-offset-5 has-text-right" style="margin-bottom: 0;">最終編集日時</p>
        <p class="has-text-left column is-3 has-text-right">
          {$ansUpdate}
          <!--            日付の表示を、桁が変わったタイミングで更新する   -->
          <!--            バックエンドかフロントで処理する    -->
        </p>
      </div>
    </div>
EOS ;
      } else {
        echo <<<"EOS"
    <div class="content normalAnswer">
      <div class="content columns is-mobile mt-4 userInfo">
        <figure class="image is-64x64 is-vcentered">
          <img src="https://placehold.jp/24/1fc7bb/ffffff/150x150.png?text=user%20image" alt="ダミー画像" class="is-rounded">
        </figure>
        <div class="column">
          <p class="is-size-6-widescreen is-size-7-mobile mb-0">
            {$ansUser}
          </p>
          <div class="columns questionDateWrapper is-mobile">
            <p class="has-text-left column is-3 has-text-right is-offset-6 is-offset-7-widescreen">質問日時</p>
            <p class="has-text-left column is-3 has-text-right">
              {$result["answer_date"]}
            </p>
          </div>
        </div>
      </div>
      <div class="py-4 px-6 answerTextArea">
        {$result["answer_detail"]}
      </div>
      <div class="columns answerDateWrapper mb-5 is-mobile">
        <p class="has-text-left column is-4 is-offset-5 has-text-right" style="margin-bottom: 0;">最終編集日時</p>
        <p class="has-text-left column is-3 has-text-right">
          {$ansUpdate}
          <!--            日付の表示を、桁が変わったタイミングで更新する   -->
          <!--            バックエンドかフロントで処理する    -->
        </p>
      </div>
    </div>
EOS ;
      }
    }
  ?>
    <div class="content answer">
      <h2 class="subtitle mt-6">回答する</h2>
      <form action="./catch.php" method="get">
        <textarea name="Answer" id="Answer"></textarea>
        <button class="button is-large mt-5 mb-6  answerButton">
          回答を投稿
        </button>
      </form>
    </div>

  </div>
</section>

<script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const easyMDE = new EasyMDE({
            element: document.getElementById('Answer'),
            maxHeight: "200px"
        });
    })
</script>
</body>
</html>
