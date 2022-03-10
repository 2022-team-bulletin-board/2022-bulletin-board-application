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
    <section id="">
      <div class="container">
        <div class="search-result-text">検索結果：</div>
      
        <ul class="searched-list">
          <!-- 繰り返し表示される部分 -->
          <li class="searched-item">
            <a href="#">
              <h3 class="question-title">質問のタイトルが表示されます</h3>
            </a>
            <p class="question-content">質問の最初の方の表示と、タグを表示させます。タイトル同様はみでた箇所は</p>
            <div class="bottom-info">
              <div class="tags">
                <span class="tag answer-count">1回答</span>
                <span class="tag">Java</span>
                <span class="tag">PHP</span>
                <span class="tag">基本情報技術者試験</span>
              </div>
              <span class="answered-date">回答日時：2022-3-10</span>
            </div>
          </li>
          <li class="searched-item">
            <a href="#">
              <h3 class="question-title">質問のタイトルが表示されます</h3>
            </a>
            <p class="question-content">質問の最初の方の表示と、タグを表示させます。タイトル同様はみでた箇所は</p>
            <div class="bottom-info">
              <div class="tags">
                <span class="tag answer-count best"><i class="fa-solid fa-check"></i>1回答</span>
                <span class="tag">Java</span>
                <span class="tag">PHP</span>
                <span class="tag">基本情報技術者試験</span>
              </div>
              <span class="answered-date">回答日時：2022-3-10</span>
            </div>
          </li>
        </ul>
      </div>
    </section>
  </main>
</body>
</html>
