<?php 

  session_start();

  if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] !== "") {

    require_once dirname(__FILE__).'/db/question.php';

    if (isset($_GET["search_word"]) ) {
      $keyword = htmlspecialchars($_GET["search_word"]);
      $results = searchQuestionWithWord($keyword);
      $size = count($results);
      $result_text = $size > 0 ? "${size}件ヒットしました。" : "見つかりませんでした。";
    } else {
      header("Location:index.php");
    } 
  } else {
    header("Location:index.php");
  } 

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/search.css">
  <title>Document</title>
</head>
<body>
  <?php include 'header.php';?>
  <main>
    <section>
      <div class="container">
        <div class="search-result-text"><?php echo $keyword === '' ? '' : "「${keyword}」の検索結果：<br class=\"sp\">${result_text}"?></div>
      
        <ul class="searched-list">
          <?php foreach($results as $result):?>
          <li class="searched-item">
            <a href="./DetailQuestion.php?question_id=<?php echo $result['question_id']; ?>">
              <h3 class="question-title"><?php echo $result['question_title']; ?></h3>
            </a>
            <p class="question-content"><?php echo $result['question_detail']; ?></p>
            <div class="bottom-info">
              <div class="tags">
                <?php if($result['question_bestanswer'] !== null): ?>
                  <span class="tag answer-count best">
                    <i class="fa-solid fa-check"></i><?php echo $result['answer_count'].'回答'; ?>
                  </span>
                <?php elseif($result['answer_count'] ==  0): ?>
                  <span class="tag answer-count yet">
                    <?php echo '未回答'; ?>
                  </span>
                <?php else: ?>
                  <span class="tag answer-count">
                    <?php echo $result['answer_count'].'回答'; ?>
                  </span>
                <?php endif; ?>
                <!-- タグをつける場合ここで繰り返し 下記はダミー　-->
                <!-- <span class="tag">Java</span>
                <span class="tag">PHP</span>
                <span class="tag">基本情報技術者試験</span> -->
              </div>
              <span class="answered-date">投稿日時：<?php echo $result['question_created'];?></span>
            </div>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>
  </main>
</body>
</html>
