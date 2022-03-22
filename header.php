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
      <div class="humburger-menu">
        <div class="menu-btn">
          <span></span>
        </div>
      </div>
    </div>
    <div class="sp-nav">

      <nav class="drawer-content">
        <ul class="drawer-menu">
          <li class="drawer-menu-item">
            <a href="./postQuestion.php">質問する</a>
          </li>
          <li class="drawer-menu-item">
            <a href="./changeUserInfo.php">ユーザー情報</a>
          </li>
          <li class="drawer-menu-item">
            <a href="./home.php">ホーム</a>
          </li>
          <li class="drawer-menu-item">
            <a href="./logout.php">ログアウト</a>
          </li>
        </ul>
      </nav>
    </div>
    <script src="./js/header.js"></script>
  </header>
