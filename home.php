<?php 
  session_start();
  if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] !== "") {

    require_once dirname(__FILE__).'/db/question.php';
    require_once dirname(__FILE__).'/func/UsersFunc.php';

    $results = selectRecommendedQuestion();
    $userId = $_SESSION["user_id"];
    $myResults = selectMyQuestion($userId);
  } else {
    header("Location:index.php");
    exit();
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
  <link rel="stylesheet" href="css/home.css">
  <link rel="stylesheet" href="css/myList.css">
  <title>Document</title>
</head>
<body>
  <?php include 'header.php';?>
  <main>
    <section id="home">
      <div class="container">
        <div class="home-inner-wrapper">
          <div class="latest-list-container">
            <div class="top-title">最新の質問</div>
            <ul class="latest-list">
              <?php foreach($results as $result): ?>
              <li class="list-item">
              <a href="./DetailQuestion.php?question_id=<?php echo $result["question_id"]; ?>">
                  <h3 class="question-title"><?php echo hsc($result["question_title"]); ?></h3>
                </a>
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
          <div class="my-list-container">
            <div class="top-title">自分の質問</div>
            <ul id="myList" class="my-list">
              <?php foreach($myResults as $myResult): ?>
              <li class="list-item my-lists">
                <a href="./DetailQuestion.php?question_id=<?php echo $myResult["question_id"]; ?>">
                  <h3 class="question-title"><?php echo hsc($myResult["question_title"]); ?></h3>
                </a>
                <div class="bottom-info">
                  <div class="tags">
                    <?php if($myResult['question_bestanswer'] !== null): ?>
                      <span class="tag answer-count best">
                        <i class="fa-solid fa-check"></i><?php echo $myResult['answer_count'].'回答'; ?>
                      </span>
                    <?php elseif($myResult['answer_count'] ==  0): ?>
                      <span class="tag answer-count yet">
                        <?php echo '未回答'; ?>
                      </span>
                    <?php else: ?>
                      <span class="tag answer-count">
                        <?php echo $myResult['answer_count'].'回答'; ?>
                      </span>
                    <?php endif; ?>
                  </div>
                  <span class="answered-date">投稿日時：<?php echo $myResult['question_created'];?></span>
                </div>
              </li>
              <?php endforeach; ?>
            </ul>
            <div id="viewButton" class="view-button">
              <span>さらに表示</span>
              <i class="fa-solid fa-chevron-down"></i>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <script src="js/listToggle.js"></script>
</body>
</html>
