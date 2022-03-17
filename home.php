<?php 

  session_start();

  require_once dirname(__FILE__).'/db/question.php';

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
              <li class="list-item">
                <a href="#">
                  <h3 class="question-title">質問のタイトルが表示されます。質問のタイトルが表示されます。質問のタイトルが表示されます。</h3>
                </a>
                <p class="question-content">質問詳細が表示されます。質問詳細が表示されます。質問詳細が表示されます。</p>
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
                    <span class="tag">Java</span>
                    <span class="tag">PHP</span>
                    <span class="tag">基本情報技術者試験</span>
                  </div>
                  <span class="answered-date">投稿日時：<?php echo $result['question_created'];?></span>
                </div>
              </li>
              <li class="list-item">
                <a href="#">
                  <h3 class="question-title">質問のタイトルが表示されます。</h3>
                </a>
                <p class="question-content">質問詳細が表示されます。質問詳細が表示されます。質問詳細が表示されます。</p>
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
                    <span class="tag">Java</span>
                    <span class="tag">PHP</span>
                    <span class="tag">基本情報技術者試験</span>
                  </div>
                  <span class="answered-date">投稿日時：<?php echo $result['question_created'];?></span>
                </div>
              </li>
              <li class="list-item">
                <a href="#">
                  <h3 class="question-title">質問のタイトルが表示されます。</h3>
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
                    <span class="tag">Java</span>
                    <span class="tag">PHP</span>
                    <span class="tag">基本情報技術者試験</span>
                  </div>
                  <span class="answered-date">投稿日時：<?php echo $result['question_created'];?></span>
                </div>
              </li>
            </ul>
          </div>
          <div class="my-list-container">
            <div class="top-title">自分の質問</div>
            <ul class="my-list">
              <li class="list-item">
                <a href="#">
                  <h3 class="question-title">質問のタイトルが表示されます。</h3>
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
                  </div>
                  <span class="answered-date">投稿日時：<?php echo $result['question_created'];?></span>
                </div>
              </li>
              <ul class="my-list">
              <li class="list-item">
                <a href="#">
                  <h3 class="question-title">質問のタイトルが表示されます。</h3>
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
                  </div>
                  <span class="answered-date">投稿日時：<?php echo $result['question_created'];?></span>
                </div>
              </li>
              <ul class="my-list">
              <li class="latest-item">
                <a href="#">
                  <h3 class="question-title">質問のタイトルが表示されます。</h3>
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
                  </div>
                  <span class="answered-date">投稿日時：<?php echo $result['question_created'];?></span>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>
</html>
