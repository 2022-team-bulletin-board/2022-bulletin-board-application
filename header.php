<header class="header">
    <div class="header-wrapper">
      <a href="./home.php"><h1 class="logo">bulletin borad app</h1></a>
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
      <div class="humburger-menu">
        <div class="menu-btn">
          <span></span>
        </div>
      </div>
    </div>
    <div class="header-bottom">
      <div class="search-box sp">
        <form action="searchQuestion.php" method="GET" id="search-form">
          <input type="search" name="search_word" placeholder="検索したいワードを入力してください">
          <button type="submit" class="btn search">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </form>
      </div>
      <div class="links-box sp">
          <a href="./postQuestion.php" class="header-link">質問する</a>
          <a href="./changeUserInfo.php" class="header-link">ユーザー情報</a>
          <a href="./home.php" class="header-link">ホーム</a>
          <a href="./logout.php" class="header-link">ログアウト</a>
      </div>
    </div>
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/header.js"></script>
  </header>
