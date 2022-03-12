<?php
    require_once dirname(__FILE__).'/db/question.php';

    $answerId = 0;

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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    div {
      border: 1px solid black;
    }
  </style>
</head>
<body>
  <?php
  $updateDate = isset($results[0]["question_update"]) ? $results[0]["question_update"] : "更新ナシ";
  echo <<< "EOS"
<div>
<h2>title: {$results[0]["question_title"]}</h2>
<p>投稿者名: {$results[0]["qu_name"]}</p>
<p>投稿日時: {$results[0]["question_created"]}</p>
<p>更新日時: {$updateDate}</p>
<p>閲覧数: {$results[0]["question_view"]}</p>
<p>質問詳細: {$results[0]["question_detail"]}</p>
</div>
EOS ;
?>
回答を入力: <textarea name="answer" id="answer" cols="30" rows="10"></textarea><br>
<input type="button" value="回答">
<?php
  if ($results[0]["ans_cnt"] !== 0) {
?>
<div id="answer-div">
<p id="answer-success"></p>
<?php
  foreach ($results as $result) {
    $answerId = $result["answer_id"] > $answerId ? $result["answer_id"] : $answerId;
    $ansUpdate = isset($result["answer_update"]) ? $result["answer_update"] : "更新ナシ";
    $ansUser = isset($result["qa_name"]) ? $result["qa_name"] : "削除済みユーザー";
    $best = $results[0]["question_bestanswer"] === $result["answer_id"] ? "ベストアンサー" : "";
    echo <<<"EOS"
<div>
<h3>回答者: {$ansUser}  {$best}</h3>
<p>回答日時: {$result["answer_date"]}</p>
<p>回答更新日: {$ansUpdate}</p>
<p>回答: {$result["answer_detail"]}</p>
</div>
EOS ;
    }
  }
    // 非同期で使う変数の定義
    echo "<script>let answerId = " . $answerId . "</script>";
  ?>
</div>
  <script src="js/jquery-3.6.0.min.js"></script>
  <script src="js/answer.js"></script>
</body>
</html>
