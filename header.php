<?php
  // session_start();

  // if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] === '') {
  //   header("Location:index.php");
  // }
?>

<header class="header">
    <div class="header-wrapper">
      <h1>bulletin borad app</h1>
      <div class="search-box">
        <form action="searchQuestion.php" method="GET" id="search-form">
          <input type="search" name="search_word" placeholder="検索したいワードを入力してください">
          <button type="submit" class="btn search">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </form>
      </div>
      <div class="links-box">
        <a href="./postQuestion.php" class="header-link">質問する</a>
        <a href="./changeUserInfo.php" class="header-link">ユーザー情報</a>
        <a href="./home.php" class="header-link">ホーム</a>
        <a href="./logout.php" class="header-link">ログアウト</a>
      </div>
    </div>
  </header>
