<?php
require_once dirname(__FILE__) . '/db/question.php';
require_once dirname(__FILE__) . '/func/checkTimeDiff.php';
require_once dirname(__FILE__) . '/func/UsersFunc.php';

$answerId = 0;

// セッションの開始
session_start();

if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] !== "" &&
  isset($_GET["question_id"]) && $_GET["question_id"] !== ""
) {

  if (isset($_SESSION["update_result"])) {
    $alert = "<script type='text/javascript'>alert('" . $_SESSION["update_result"][0]["result"] . "');</script>";
    echo $alert;
    unset($_SESSION["update_result"]);
  }

  // セッションからユーザーidの取り出し
  $user_id = $_SESSION["user_id"];

  // getからquestion_idの取り出し
  $question_id = $_GET["question_id"];
  // question.phpのdetailQuestionを呼び出し、結果を取得
  $results = detailQuestion($question_id);
  // resultに値がない場合は、存在しないページへのアクセスになるのでエラーページに遷移させる
  if (count($results) === 0) {
    header("Location:notFoundError.php");
  }

  // question_idの存在が確認できたので閲覧数の追加
  questionViewAdd($question_id);


} else {
  header("Location:index.php");
  exit();
}
?>
<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/prism.css">
  <link rel="stylesheet" href="./css/framework/bulma/css/bulma.min.css">
  <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
  <link rel="stylesheet" href="./css/detailQuestion.css">
  <link rel="stylesheet" href="./css/main.css">
  <!--  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
  <script src="js/prism.js"></script>

  <title>質問詳細</title>
</head>
<body>
<?php require_once './header.php' ?>

<section class="main section">
  <div class="column is-centered is-8-widescreen is-10-tablet is-offset-2-widescreen is-offset-1-tablet is-offset-1">
    <?php
    $updateDate = isset($results[0]["question_update"]) ? checkDiffTime($results[0]["question_update"]) : "更新ナシ";
    $questionCreated = checkDiffTime($results[0]["question_created"]);
    $title = hsc($results[0]["question_title"]);
    $quName = hsc($results[0]["qu_name"]);
    $quCreated = hsc($results[0]["question_created"]);
    $view = hsc($results[0]["question_view"]);
    $detail = hsc($results[0]["question_detail"]);

    $pattern = "/(`{3}\S+(\r\n|\n))|(`{3})/";

    $cnt = 0;

    $detail2 = preg_replace_callback(
      $pattern,
      function ($matches) {
        global $cnt;
        preg_match('/`{3}\S+\r\n/', $matches[0], $date_match);
        $date_match = isset($date_match[0]) ? $date_match[0] : "";
        $date_match = str_replace("```", "", $date_match);
        $date_match = str_replace("\r\n", "", $date_match);
        $date_match = str_replace("\n", "", $date_match);
        return $cnt++ % 2 == 0 ? '<pre><code class="language-' . $date_match . '">' : "</pre></code>";
      },
      $detail);
    if ($cnt % 2 == 1) {
      $cnt++;
      $detail2 = $detail2 . "</pre></code>";
    }

    if ($cnt % 2 == 1) {
      $cnt++;
      $detail2 = $detail2 . "</pre></code>";
    }

    echo <<< "EOS"
    <div id="questionTitleView" class="columns icon-text toggleTitle" data-view="true">
      <h1 class="column 12 title is-medium has-text-left icon-text has-icons-right mb-0">
          {$title}
      </h1>
EOS;
    if ($results[0]["qu_id"] == $user_id) {
      echo <<< "EOS"
<!--      質問者にのみ表示するアイコン-->
      <span class="icon is-small titleIcon viewAboutBA" data-view="true" data-view-Ba="true"><i class="far fa-2x fa-edit toggleTitleEdit"></i></span>
    </div>
      <form action="./func/updateQuestionTitle.php" method="post" id="questionTitleEdit" class="columns has-addons control is-grouped is-vcentered toggleTitle" data-view="false">
      <input type="text" class="input is-8 mr-3" name="title" value="{$title}">
      <button type="submit" class="button is-small is-1 mr-3 toggleTitleEdit" name="question_id" value="{$question_id}">保存</button>
      <button type="submit" class="button is-small is-1 toggleTitleEdit">破棄</button>
    </form>
EOS;
    } else {
      echo "</div>";
    }

    echo <<< "EOS"
    <!--    ユーザー情報の表示部分   -->
    <div class="content columns is-mobile is-multiline mt-4 userInfo">
      <figure class="image is-64x64 is-vcentered">
        <img src="https://placehold.jp/24/1fc7bb/ffffff/150x150.png?text=user%20image" alt="ダミー画像" class="is-rounded">
      </figure>
      <div class="column pb-0 userInfoDiv">
        <p class="is-size-6-widescreen is-size-7-mobile mb-0">
          {$quName}
        </p>
        <div class="columns questionDateWrapper is-mobile">
          <p class="column is-3 is-offset-7-widescreen is-offset-6
           pb-0 mb-1 has-text-right">
            質問日時
          </p>
          <p class="column is-3 has-text-right
            pb-0 mb-0">
            {$questionCreated}
          </p>
        </div>
      </div>
      <div class="column is-12 is-mobile mb-2 mr-2">
        <div class="columns is-mobile">
          <p class="has-text-right column mb-0 py-0 is-2 is-offset-8-widescreen is-offset-8">閲覧数</p>
          <p class="has-text-centered mb-0 pt-0 column is-2">
            <span>{$view}</span>回
          </p>
        </div>
      </div>
    </div>

    <div class="content question">
    <pre><code>{$detail2}</pre></code>
      <div id="questionTagArea" class="px-4 tags mt-3">
<!--        <span class="tag is-link is-light">タグの</span>-->
<!--        <span class="tag is-link is-light">はみ出るまで伸ばすと</span>-->
<!--        <span class="tag is-link is-light">自動で改行されて</span>-->
<!--        <span class="tag is-link is-light">表示される</span>-->
      </div>
      <div class="columns is-mobile is-vcentered">
EOS;
    if ($results[0]["qu_id"] == $user_id) {
      echo <<< "EOS"
<!--        質問者にのみ、編集、削除ボタンを表示する-->
<!--        非表示にする際は、↓ の div を data-view="false" にする-->
        <div class="column is-grouped questionEditButtonGroup viewAboutBA" data-view="true" data-view-Ba="true">
          <button class="button is-link is-inverted mr-3 modalButton"
                  data-modal-field="questionEditModal">
            <span class="icon"><i class="fas fa-edit"></i></span>
            <span>編集</span>
          </button>
          <button class="button is-danger modalButton" data-modal-field="questionDeleteModal">
            <span class="icon"><i class="fas fa-trash-alt"></i></span>
            <span>削除</span>
          </button>
        </div>
        <div id="questionEditModal" class="modal">
          <div class="modal-background"></div>
          <div class="modal-content px-4 py-5">
            <h2 class="subtitle">質問の編集</h2>
            <form action="./func/updateQuestionDetail.php" method="POST">
              <textarea name="detail" id="questionEditArea" cols="30" rows="10">{$detail}</textarea>
              <button class="button mt-5 is-medium customButton" name="question_id" value="{$question_id}">編集を確定する</button>
            </form>
          </div>
          <button id="questionEditModalClose" class="modal-close is-large modalCloseButton"
                  aria-label="close" data-modal-field="questionEditModal"></button>
        </div>
        <div id="questionDeleteModal" class="modal">
          <div class="modal-background"></div>
          <div class="modal-card">
            <header class="modal-card-head">
              <p class="modal-card-title">本当に削除しますか？</p>
              <button class="delete modalCloseButton" data-modal-field="questionDeleteModal" aria-label="close"></button>
            </header>

            <section class="modal-card-body">
              質問の復元はできませんがよろしいですか？
            </section>
              <footer class="modal-card-foot">
                <button class="button is-danger modalCloseButton" data-modal-field="questionDeleteModal" onclick="location.href='./func/deleteQuestion.php?question_id={$question_id}'">削除</button>
                <button class="button modalCloseButton" data-modal-field="questionDeleteModal">戻る</button>
              </footer>
          </div>
        </div>
EOS;
    }

    echo <<< "EOS"
        
        <div class="columns questionDateWrapper is-mobile">
          <p class="has-text-left column is-4 is-offset-5 has-text-right" style="margin-bottom: 0;">最終編集日時</p>
          <p class="has-text-left column is-3 has-text-right">
            {$updateDate}
          </p>
        </div>
      </div>
    </div>
EOS;
    //    ログインユーザの質問には回答フォームが表示されないようにする
    if ($results[0]["qu_id"] != $user_id) {
      echo <<< "EOS"
    <div class="content answer mb-6 viewAboutBA" data-view-Ba="true">
      <h2 class="subtitle mt-6">回答する</h2>
        <textarea name="Answer" id="Answer"></textarea>
        <button type="button" class="button is-large mt-5 mb-6 customButton answerButton" id="ans_btn">
          回答を投稿
        </button>
    </div>

EOS;
    }
    if ($results[0]["ans_cnt"] !== 0) {
      $answerCount = count($results);
      $bestAnswerFlg = false;
      echo "<h2 class=\"subtitle mt-6 answerTitle\">${answerCount}件の回答</h2>";
      foreach ($results as $result) {
        $answerId = hsc($result["answer_id"] > $answerId ? $result["answer_id"] : $answerId);
        $ansUpdate = isset($result["answer_update"]) ? checkDiffTime($result["answer_update"]) : "更新ナシ";
        $ansUser = hsc(isset($result["qa_name"]) ? $result["qa_name"] : "削除済みユーザー");
//        ベストアンサーの判定をboolで行うか、文字列をそのまま表示するのか
//        $best = hsc($results[0]["question_bestanswer"] === $result["answer_id"] ? "ベストアンサー" : "");
        $best = $results[0]["question_bestanswer"] === $result["answer_id"] ? true : false;
//        ベストアンサーが存在する時、bestAnswerFlg を true に変更する
        if ($bestAnswerFlg === false && $best === true) {
          $bestAnswerFlg = true;
        }
        $answerDate = checkDiffTime($result['answer_date']);
        $answerDetail = hsc($result["answer_detail"]);
        $answerDetail = preg_replace_callback(
          $pattern,
          function ($matches) {
            global $cnt;
            preg_match('/`{3}\S+(\r\n|\n)/', $matches[0], $date_match);
            $date_match = isset($date_match[0]) ? $date_match[0] : "";
            $date_match = str_replace("```", "", $date_match);
            $date_match = str_replace("\r\n", "", $date_match);
            $date_match = str_replace("\n", "", $date_match);
            return $cnt++ % 2 == 0 ? '<pre><code class="language-' . $date_match . '">' : "</pre></code>";
          },
          $answerDetail);
        if ($cnt % 2 == 1) {
          $cnt++;
          $answerDetail = $answerDetail . "</pre></code>";
        }
        if ($best) {
          echo <<<"EOS"
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
              {$answerDate}
            </p>
          </div>
        </div>
      </div>
      <div class="py-4 px-6 answerTextArea">
      <pre><code>{$answerDetail}</pre></code>
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
EOS;
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
              {$answerDate}
            </p>
          </div>
        </div>
      </div>
      <div class="py-4 px-6 answerTextArea">
      <pre><code>{$answerDetail}</pre></code>
      </div>
EOS;

    if ($results[0]["qu_id"] === $user_id){
      echo <<< "EOS"
      <div class="answerDateWrapper mb-5 has-text-right viewAboutBA" data-view-Ba="true">
          <button class="button is-success is-small modalButton" data-modal-field="questionBAModal">
            <span class="icon"><i class="fa-solid fa-check"></i></span>
            <span>ベストアンサー</span>
          </button>
      </div>
      <div id="questionBAModal" class="modal">
        <div class="modal-background"></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">本当によろしいですか?</p>
            <button class="delete modalCloseButton" data-modal-field="questionBAeModal" aria-label="close"></button>
          </header>
          <section class="modal-card-body" style="transform: none!important;">
            1度選んだベストアンサーは後から変更できません。本当によろしいですか?
          </section>
          <footer class="modal-card-foot">
            <button class="button is-success modalBAButton" data-modal-field="questionBAModal" onclick="location.href='./func/changeBestAnswer.php?question_id={$question_id}&answer_id={$answerId}'">ベストアンサー</button>
            <button class="button modalCloseButton" data-modal-field="questionBAModal">戻る</button>
          </footer>
        </div>
      </div>
EOS;
    }

    echo "</div>";
        }
      }
    }
    // 非同期で使う変数の定義
    echo "<script>let answerId = " . $answerId . "</script>";
    ?>

  </div>
</section>

<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/answer.js"></script>
<script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
<script src="js/viewToggle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.1/lottie.min.js"
        integrity="sha512-CWKGqmXoxo+9RjazbVIaiFcD+bYEIcUbBHwEzPlT0FilQq3TCUac+/uxZ5KDmvYiXJvp32O8rcgchkYw6J6zOA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    lottie.loadAnimation({
        container: document.getElementById('bestAnswer'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: 'css/animation/data.json',
        rendererSettings: {
            className: 'svgAnimation'
        }
    });
</script>
<script src="js/main.js"></script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const viewAboutBestAnswer = Array.from(document.getElementsByClassName('viewAboutBA'));

        function toggleViewAboutBestAnswer() {
            viewAboutBestAnswer.forEach((val) => {
                // false -> 非表示
                // true -> 表示
                val.dataset.viewBa = 'false';
            })
        }

        if (<?php echo $bestAnswerFlg?> == 1
    )
        {
            console.log('work');
            toggleViewAboutBestAnswer();
        }
    })
</script>

</body>
</html>
